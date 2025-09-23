  /**
   * Recently accessed items block override to gracefully handle
   * the block not being on the page.
   * Run grunt amd after any changes to generate the build files, unless automated.
   */
define([], function() {

  const SELECTORS = {
    SHOWMORE_LINK: '[data-region="recentlyaccesseditems-view"] [data-action="more-items"]',
    ITEMS_LIST: '[data-region="items-list"]',
  };

  const registerEventListeners = () => {
    const showmoreLink = document.querySelector(SELECTORS.SHOWMORE_LINK);
    if (!showmoreLink) {
      return;
    }

    showmoreLink.addEventListener('click', (e) => {
      e.preventDefault();
      showmoreLink.classList.add('d-none');

      const list = document.querySelector(SELECTORS.ITEMS_LIST);
      if (!list) {
        return;
      }

      for (const item of list.children) {
        item.style.display = 'block';
        item.classList.remove('d-none');
      }
    });
  };

  const init = () => {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', registerEventListeners, { once: true });
    } else {
      registerEventListeners();
    }
  };

  return { init };
});
