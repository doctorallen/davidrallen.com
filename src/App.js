import './index.scss';
import BashLine from './components/BashLine';
import { useEffect, useState } from 'react';
import useKeyPress from './useKeyPress';
import CompletedCommand from './components/CompletedCommand';

function App() {
  const [commandHistory, setCommandHistory] = useState([]);
  const [typedCommand, setTypedCommand] = useState('');
  const [acceptingInput, setAcceptingInput] = useState(false);

  const availableCommands = ['help', 'clear', 'info'];

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

  const executeClear = () => {
    setCommandHistory([]);
    reset();
  };

  const executeCommand = () => {
    if (!availableCommands.includes(typedCommand)) {
      setTypedCommand('');
      setCommandHistory([
        ...commandHistory,
        {
          command: typedCommand,
          success: false,
          output: `davesh: command not found: ${typedCommand}`,
        },
      ]);
    }

    if (typedCommand === 'clear') {
      executeClear();
    }
  };

  useKeyPress(handleKeyUp);

  const randBetween = (min, max) => {
    // min and max included
    return Math.floor(Math.random() * (max - min + 1) + min);
  };

  useEffect(() => {
    const text =
      'Welcome to my website. Type a command and hit "Enter" to execute. Type "help" for a list of all available commands.';
    const letters = text.split('');
    let totalTimeout = 0;
    letters.reduce((word, letter) => {
      const timeoutAmount = randBetween(20, 50);
      console.log(word, letter);
      totalTimeout += timeoutAmount;
      const newText = word + letter;
      setTimeout(() => {
        setTypedCommand(newText);
        if (newText === text) {
          setTimeout(() => {
            setCommandHistory([
              ...commandHistory,
              {
                command: text,
                success: true,
              },
            ]);
            reset();
          }, 450);
        }
      }, totalTimeout);

      return newText;
    }, '');
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
