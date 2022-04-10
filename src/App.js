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
    console.log(event.key);
    console.log(typedCommand);
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

  const reset = () => {
    setTypedCommand('');
    setAcceptingInput(true);
  };

  const pushIntoHistory = (command) => {
    setCommandHistory((oldHistory) => [...oldHistory, command]);
  };

  const executeClear = () => {
    setCommandHistory([]);
  };

  const sleep = async (timeout = 100) => {
    return new Promise((resolve) => {
      setTimeout(() => {
        resolve();
      }, timeout);
    });
  };

  const executeInfo = () => {
    pushIntoHistory({
      command: typedCommand,
      success: true,
      output: <div>Things</div>,
    });
  };

  const executeTheOne = async () => {
    await autoType('Wake up, Neo...');
    await sleep(500);
    reset();
    await autoType('The Matrix has you...');
  };

  const executeCommand = () => {
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
      case 'clear':
        executeClear();
        break;
      case 'info':
        executeInfo();
        break;
      case 'neo':
        executeTheOne();
        break;
    }

    reset();
  };

  useKeyPress(handleKeyUp);

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
              reset();
            }, 450);
            resolve();
          }
        }, totalTimeout);

        return newText;
      }, '');
    });
  };

  useEffect(() => {
    const text =
      'Welcome to my website. Type a command and hit "Enter" to execute. Type "help" for a list of all available commands.';
    autoType(text);
  }, []);

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
