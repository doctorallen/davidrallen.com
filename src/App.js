import './index.scss';
import BashLine from './components/BashLine';
import { useEffect, useState, useRef } from 'react';
import useKeyPress from './useKeyPress';
import CompletedCommand from './components/CompletedCommand';

function App() {
  const bashLineRef = useRef(null);
  const Banner = () => {
    return (
      <div className="banner">
        <div>
          Welcome to Davenix 32.4.10 LTS (GNU/Linux 5.3.90-management x86_64)
        </div>
        <ul className="documentation-list">
          <li>
            * Resume:&nbsp;&nbsp;&nbsp;&nbsp;
            <a href="/">https://davidrallen.com/resume.pdf</a>
          </li>
          <li>
            * GitHub:&nbsp;&nbsp;&nbsp;&nbsp;
            <a target="_blank" href="https://github.com/doctorallen">
              https://github.com/doctorallen
            </a>
          </li>
          <li>
            * Contact:&nbsp;&nbsp;&nbsp;
            <a target="_blank" href="mailto:jobs@davidrallen.com?subject=Hello">
              jobs@davidrallen.com
            </a>
          </li>
        </ul>
        <div>System information as of {new Date().toString()}</div>
        <div className="row">
          <div className="column">
            <ul className="sys-list">
              <li>System load: 0.0</li>
              <li>Usage of /: 5.3% of 1990 GB.</li>
              <li>Memory usage: 32%</li>
              <li>Swap usage: 0%</li>
            </ul>
          </div>
          <div className="column">
            <ul className="sys-list">
              <li>Processes: 87</li>
              <li>Users logged in: 9</li>
              <li>IP address for eth0: 127.0.0.1</li>
            </ul>
          </div>
        </div>
      </div>
    );
  };

  const [commandHistory, setCommandHistory] = useState([
    { command: 'ssh broadbrain', success: true, output: <Banner /> },
  ]);
  const [typedCommand, setTypedCommand] = useState('');
  const [acceptingInput, setAcceptingInput] = useState(false);

  const availableCommands = {
    help: 'display this list of available commands',
    clear: 'clear the console',
    info: 'display information about David Allen',
    neo: 'Mr. Anderson',
    motd: 'Display the banner message of the day',
    tech: 'Display information about how this website was built',
  };

  const easterEggResponse = {
    'fuck you': 'No, fuck YOU!',
  };

  const handleKeyUp = (event) => {
    if (!acceptingInput) {
      return;
    }
    scrollToBottom();
    if (event.key.match(/^.$/g)) {
      return setTypedCommand(typedCommand + event.key);
    }
    if (event.key === 'Enter' && typedCommand !== '') {
      return executeCommand();
    }
    if (event.key === 'Backspace') {
      return setTypedCommand(typedCommand.slice(0, typedCommand.length - 1));
    }
  };

  const scrollToBottom = () => {
    bashLineRef.current?.scrollIntoView({ behavior: 'smooth' });
  };

  useKeyPress(handleKeyUp);

  const reset = () => {
    setTypedCommand('');
    setAcceptingInput(true);
  };

  const pushIntoHistory = (command) => {
    setCommandHistory((oldHistory) => [...oldHistory, command]);
    scrollToBottom();
  };

  const executeClear = async () => {
    setCommandHistory([]);
  };

  const sleep = async (timeout = 100) => {
    return new Promise((resolve) => {
      setTimeout(() => {
        resolve();
      }, timeout);
    });
  };

  const executeMOTD = async () => {
    pushIntoHistory({
      command: typedCommand,
      success: true,
      output: <Banner />,
    });
  };

  const executeInfo = async () => {
    pushIntoHistory({
      command: typedCommand,
      success: true,
      output: (
        <div className="info-container">
          <div className="inner">
            I started my journey as a Software Engineer in 2005, coding my own
            video games in Flash and Visual Basic. 15 years, over 100 clients,
            and dozens of custom applications have built my diverse tools that I
            hone by contributing to every aspect of software development; sales,
            project management, software architecture, database design, I've
            done it all. I'm a jack-of-all-trades who enjoys database design and
            server-side programming most of all.
          </div>
        </div>
      ),
    });
  };

  const executeTheOne = async () => {
    setAcceptingInput(false);
    await autoType('Wake up, Neo...');
    await sleep(500);
    await autoType('The Matrix has you...');
    await sleep(1500);
    await autoType('Follow the white rabbit.');
    await sleep(1500);
    await autoType('Knock, knock, Neo.');
  };

  const executeHelp = async () => {
    pushIntoHistory({
      command: typedCommand,
      success: true,
      output: (
        <>
          <strong>List of available commands:</strong>
          <ul className="command-list">
            <li style={{ marginBottom: '4px' }}>
              <pre>
                <strong>{`command`.padEnd(10, ' ')} description</strong>
              </pre>
            </li>
            {Object.entries(availableCommands).map(([command, description]) => {
              return (
                <li key={command}>
                  <pre>
                    {command.padEnd(10, ' ')} {description}
                  </pre>
                </li>
              );
            })}
          </ul>
        </>
      ),
    });
  };

  const executeTech = async () => {
    pushIntoHistory({
      command: typedCommand,
      success: true,
      output: (
        <>
          <strong>This website built with:</strong>
          <ul>
            <li>React 18</li>
            <li>SCSS</li>
          </ul>
          <p>
            This website was built as an homage to my customized terminal
            environment I spend most of my day. That terminal environment is
            configured with the following:
          </p>
          <ul>
            <li>macOS</li>
            <li>
              <a target="_blank" href="https://www.zsh.org/">
                Zsh
              </a>
            </li>
            <li>
              <a target="_blank" href="https://ohmyz.sh/">
                Oh My Zsh
              </a>
            </li>
            <li>
              <a
                target="_blank"
                href="https://github.com/romkatv/powerlevel10k"
              >
                Powerlevel10k
              </a>
            </li>
          </ul>
          <p>
            If you want to check it out in more detail, take a peek at my{' '}
            <a target="_blank" href="https://github.com/doctorallen/dotfiles">
              dotfiles
            </a>
            .
          </p>
        </>
      ),
    });
  };

  const executeCommand = async () => {
    const command = typedCommand.toLowerCase().trim();
    if (!Object.keys(availableCommands).includes(command)) {
      setTypedCommand('');

      if (easterEggResponse.hasOwnProperty(command)) {
        return pushIntoHistory({
          command: command,
          success: false,
          output: easterEggResponse[command],
        });
      }

      pushIntoHistory({
        command: command,
        success: false,
        output: `davesh: command not found: ${command}`,
      });
    }

    switch (command) {
      case 'help':
        await executeHelp();
        break;
      case 'clear':
        await executeClear();
        break;
      case 'info':
        await executeInfo();
        break;
      case 'neo':
        await executeTheOne();
        break;
      case 'motd':
        await executeMOTD();
        break;
      case 'tech':
        await executeTech();
        break;
    }

    reset();
  };

  const randBetween = (min, max) => {
    // min and max included
    return Math.floor(Math.random() * (max - min + 1) + min);
  };

  const autoType = (text) => {
    return new Promise((resolve) => {
      const letters = text.split('');
      let totalTimeout = 0;
      letters.reduce((word, letter) => {
        const timeoutAmount = randBetween(20, 50);
        console.log(word, letter);
        totalTimeout += timeoutAmount;
        const newText = word + letter;
        setTimeout(() => {
          setTypedCommand(newText);
          // if we've typed out all of the letters that we need to type out
          if (newText === text) {
            // give the user 450 ms to see the message before it moves into the
            // history as if the command was executed
            setTimeout(() => {
              pushIntoHistory({
                command: text,
                success: true,
              });
            }, 450);
            resolve();
          }
        }, totalTimeout);

        return newText;
      }, '');
    });
  };

  useEffect(() => {
    // const text =
    //   'Welcome to my website. Type a command and hit "Enter" to execute. Type "help" for a list of all available commands.';
    const text = 'test';
    autoType(text);
  }, []);

  // automatically resets the bashline when a history item is pushed into the
  // stack of history
  useEffect(() => {
    const latestHistoryItem = commandHistory.at(-1);
    if (latestHistoryItem && latestHistoryItem.command === typedCommand) {
      reset();
    }
  }, [commandHistory]);

  return (
    <div className="App">
      {commandHistory.map((command, index) => (
        <CompletedCommand
          key={index}
          success={command.success}
          command={command.command}
          output={command.output}
        />
      ))}
      <BashLine innerRef={bashLineRef} command={typedCommand} />
    </div>
  );
}

export default App;
