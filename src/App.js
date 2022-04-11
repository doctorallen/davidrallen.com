import './index.scss';
import BashLine from './components/BashLine';
import { useEffect, useState } from 'react';
import useKeyPress from './useKeyPress';
import CompletedCommand from './components/CompletedCommand';

function App() {
  const [commandHistory, setCommandHistory] = useState([]);
  const [typedCommand, setTypedCommand] = useState('');
  const [acceptingInput, setAcceptingInput] = useState(false);

  const availableCommands = ['help', 'clear', 'info', 'neo'];

  const easterEggResponse = {
    'fuck you': 'No, fuck YOU!',
  };

  const handleKeyUp = (event) => {
    if (!acceptingInput) {
      return;
    }
    if (event.key.match(/^[a-zA-Z\s]{1}$/g)) {
      return setTypedCommand(typedCommand + event.key);
    }
    if (event.key === 'Enter' && typedCommand !== '') {
      return executeCommand();
    }
    if (event.key === 'Backspace') {
      return setTypedCommand(typedCommand.slice(0, typedCommand.length - 1));
    }
  };

  useKeyPress(handleKeyUp);

  const reset = () => {
    setTypedCommand('');
    setAcceptingInput(true);
  };

  const pushIntoHistory = (command) => {
    setCommandHistory((oldHistory) => [...oldHistory, command]);
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

  const executeInfo = async () => {
    pushIntoHistory({
      command: typedCommand,
      success: true,
      output: (
        <div>
          I started my journey as a Software Engineer in 2005, coding my own
          video games in Flash and Visual Basic. 15 years, over 100 clients, and
          dozens of custom applications have built my diverse tools that I hone
          by contributing to every aspect of software development; sales,
          project management, software architecture, database design, I've done
          it all. I'm a jack-of-all-trades who enjoys database design and
          server-side programming most of all.
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
            {availableCommands.map((command, index) => (
              <li key={index}>{command}</li>
            ))}
          </ul>
        </>
      ),
    });
  };

  const executeCommand = async () => {
    if (!availableCommands.includes(typedCommand)) {
      setTypedCommand('');

      if (easterEggResponse.hasOwnProperty(typedCommand)) {
        return pushIntoHistory({
          command: typedCommand,
          success: false,
          output: easterEggResponse[typedCommand],
        });
      }

      pushIntoHistory({
        command: typedCommand,
        success: false,
        output: `davesh: command not found: ${typedCommand}`,
      });
    }

    switch (typedCommand) {
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
    const text = 'test';
    //   'Welcome to my website. Type a command and hit "Enter" to execute. Type "help" for a list of all available commands.';
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
      <BashLine command={typedCommand} />
    </div>
  );
}

export default App;
