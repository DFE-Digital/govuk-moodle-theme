const { spawn } = require('child_process');
const path = require('path');

const args = process.argv.slice(2);
const destArg = args.find((arg) => !arg.startsWith('--'));
const dest = destArg || process.env.MOODLE_THEME_PATH;
const watch = args.includes('--watch');
const verbose = args.includes('--verbose');

if (!dest) {
  console.error('❌ You must specify a destination path.');
  console.error(
    'Usage: npm run copy:theme -- <destination> [--watch] [--verbose]',
  );
  process.exit(1);
}

const sources = [
  { from: 'style/**/*', to: path.join(dest, 'style') },
  { from: 'templates/**/*', to: path.join(dest, 'templates') },
  { from: 'pix/**/*', to: path.join(dest, 'pix') },
];

const runCpx = ({ from, to }) => {
  const cmdArgs = ['cpx', from, to];
  if (watch) cmdArgs.push('--watch');
  if (verbose) cmdArgs.push('--verbose');

  console.log(`▶️  npx ${cmdArgs.join(' ')}`);

  const proc = spawn('npx', cmdArgs, {
    stdio: 'inherit',
    shell: false,
  });

  proc.on('error', (err) => {
    console.error(`❌ Error running cpx: ${err.message}`);
  });
};

sources.forEach(runCpx);
