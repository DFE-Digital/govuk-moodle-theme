---
# These are optional elements. Feel free to remove any of them.
status {proposed  rejected  accepted  deprecated  …  superseded by [ADR-0005](0005-example.md)}
date {YYYY-MM-DD when the decision was last updated}
deciders {list everyone involved in the decision}
consulted {list everyone whose opinions are sought (typically subject-matter experts); and with whom there is a two-way communication}
informed {list everyone who is kept up-to-date on progress; and with whom there is a one-way communication}
---
# Implementation of exponential backoff and pattern for calling Gov Notify

## Context and Problem Statement

When we call the Gov Notify client we need to add functionality to our code that allows it to retry the request *X* times if it fails initially. In order to do this we need alter how we call the client.

When implementing the [GOV.UK Design System](https://design-system.service.gov.uk/) for the [GOV.UK Moodle Theme](https://github.com/DFE-Digital/govuk-moodle-theme) we needed to reference various files from the [GOV.UK Frontend NPM Package](https://www.npmjs.com/package/govuk-frontend). This included files such as the CSS, JavaScript, images, etc. The CSS and JavaScript files were needed for the GOV.UK components to have full functionality. The primary way these files are referenced in Moodle is by adding them to the correct directories in this project (`scss`/`style`/`javascript`) and adding the file name into the `config.php` file.

Referencing the CSS as described above works as expected. However, attempting to link the [GOV.UK Design System](https://design-system.service.gov.uk/) file this way resulted in an error. After investigating we found that Moodle, or rather its JavaScript loading system RequireJS (AMD), does not fully support ECMAScript 6, more specifically ES6 modules (import/export).

The [GOV.UK Design System](https://design-system.service.gov.uk/) JavaScript file uses these modules. In order to successfully reference the JavaScript file we need to find an alternative way of linking to it.

## Considered Options

 - Find an alternative way to link the Javascript file through Moodle
 - Change the JavaScript file so that it doesn't use the Modules that Moodle doesn't support
 - Link the JavaScript file directly in one of the Templates, bypassing Moodle


## Decision Outcome

Chosen option Implement an exponential backoff policy & Implement the command pattern, because using the exponential backoff allows for more time to pass imbetween retries. This will give the Gov Notify client more time to recover and increase the chances of our request being successful. We have chosen the command pattern as this allows us to alter how we call the client, so we can add the exponential back off logic when we call the request


!-- This is an optional element. Feel free to remove. --
### Confirmation

{Describe how the implementation ofcompliance with the ADR is confirmed. E.g., by a review or an ArchUnit test.
 Although we classify this element as optional, it is included in most ADRs.}

!-- This is an optional element. Feel free to remove. --
## Pros and Cons of the Options

### Implement a retry policy

 - Good, because it will attempt to resend the request to Gov Notify should the initial request fail
 - Bad, because it will retry the client call *X* times, every *Y* seconds (both customisable), usually in very quick sucsession. If the client is down for more than a few seconds we will stop retrying and the notification will never be sent.

### Implement an exponential backoff policy

 - Good, because it will attempt to resend the request to Gov Notify should the initial request fail
 - Good, because for every notifcaiton request failure the time before we send the next request doubles. This gives the client more time recover and successfully send notification again. e.g. first retry is 1 second later, then 2 seconds, then 4 etc. 
 
### Implement the decorator pattern

 - Good, because it allows us to alter how to call the client, which means we can add the exponential back off
 - Bad, because we have to implement *all* methods in the Notification Client interace (~20 methods) in our decorator class. We only use 1 method (SendEmailAsync), so this causes a lot of irrelevant bloat in the class

### Implement the command pattern

 - Good, because it allows us to alter how to call the client, which means we can add the exponential back off
 - Good, because we can implement only the methods we use, which makes the class much less bloated. 