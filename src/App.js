import './index.scss';
import BashLine from './components/BashLine';
import { useEffect, useState, useRef } from 'react';
import useKeyPress from './useKeyPress';
import CompletedCommand from './components/CompletedCommand';
import Story from './components/Story';
import Banner from './components/Banner';
import Tech from './components/Tech';
import Menu from './components/Menu';
import Timeline from './components/Timeline';

function App() {
  // used for scrolling the user down to the bash line when the screen is too large
  const bashLineRef = useRef(null);

  // state to hold all of the command history. Has one default history item to
  // look like the user had already ssh'd into a server and is seeing a banner
  const [commandHistory, setCommandHistory] = useState([
    { command: 'ssh davidrallen.com', success: true, output: <Banner /> },
  ]);

  // the currently typed command
  const [typedCommand, setTypedCommand] = useState('');

  // whether or not the bash prompt is currently accepting input
  const [acceptingInput, setAcceptingInput] = useState(false);

  // all of the available commands with their descriptions for display in the
  // "help" command
  const availableCommands = {
    clear: 'clears the console',
    help: 'displays this list of available commands',
    menu: 'displays the menu of pages',
    motd: 'displays the banner message of the day',
    neo: 'Mr. Anderson',
    tech: 'displays information about how this website was built',
    story: 'displays my story',
    timeline: 'displays my career timeline',
  };

  // responses that are not listed in the help screen
  const easterEggResponse = {
    'fuck you': 'No, fuck YOU!',
  };

  // function used for handling user input
  const handleKeyUp = (event) => {
    // if we're not currently accepting input, return early
    if (!acceptingInput) {
      return;
    }

    // scroll the user to the bottom of the page when they type, in case they
    // have scrolled up on the page and are currently entering a command
    scrollToBottom();

    // if the user types the Enter key and there is a current command, attempt
    // to execute the current command
    if (event.key === 'Enter' && typedCommand !== '') {
      return executeCommand();
    }

    // if the user types the Backspace key, we need to delete the last key they
    // entered
    if (event.key === 'Backspace') {
      return setTypedCommand(typedCommand.slice(0, typedCommand.length - 1));
    }

    // if the user types a key that is a single digit, we want to display it
    if (event.key.match(/^.$/g)) {
      return setTypedCommand(typedCommand + event.key);
    }
  };

  // setup our custom hook to call our handleKeyUp function when the user
  // hits a key
  useKeyPress(handleKeyUp);

  // function to scroll the user to the bottom of the page
  const scrollToBottom = () => {
    bashLineRef.current?.scrollIntoView({ behavior: 'smooth' });
  };

  // reset the bash prompt
  const reset = () => {
    setTypedCommand('');
    setAcceptingInput(true);
  };

  // utility function for generating a random number between two integers
  const randBetween = (min, max) => {
    // min and max included
    return Math.floor(Math.random() * (max - min + 1) + min);
  };

  // function that will use timeouts to render text to the screen as if someone
  // is typing the command
  const autoType = (text) => {
    return new Promise((resolve) => {
      // split the text we want to display into individual letters
      const letters = text.split('');
      // create a counter to store the amount of time the current letter is going
      // to take to display on the screen
      let totalTimeout = 0;
      // loop over all of the letters
      letters.reduce((word, letter) => {
        // choose a random keystroke time between two values so the typing seems
        // more realistic
        const timeoutAmount = randBetween(20, 50);
        // add to our total timeout counter
        totalTimeout += timeoutAmount;
        // build the text that should be displayed on the screen
        const newText = word + letter;
        setTimeout(() => {
          // update the state for what text should be displayed on the screen
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

        // return the newText for the reducer
        return newText;
      }, '');
    });
  };

  // use effect hook to run when the page first loads
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

  // push the passed command into the history stack
  const pushIntoHistory = (command) => {
    // maintain the old history, and add the new one. We are getting the old history
    // from the hook so that we can call this function from timeouts and intervals
    setCommandHistory((oldHistory) => [...oldHistory, command]);
    // scroll the user to the bottom of the page after a command output is displayed
    scrollToBottom();
  };

  // sleep utility function used for the auto typer
  const sleep = async (timeout = 100) => {
    return new Promise((resolve) => {
      setTimeout(() => {
        resolve();
      }, timeout);
    });
  };

  // execute the clear command
  const executeClear = async () => {
    setCommandHistory([]);
  };

  // execute the motd command
  const executeMOTD = async () => {
    pushIntoHistory({
      command: typedCommand,
      success: true,
      output: <Banner />,
    });
  };

  // execute the motd command
  const executeMenu = async () => {
    pushIntoHistory({
      command: typedCommand,
      success: true,
      output: <Menu />,
    });
  };

  // execute the story command
  const executeStory = async () => {
    pushIntoHistory({
      command: typedCommand,
      success: true,
      output: <Story />,
    });
  };

  // execute the timeline command
  const executeTimeline = async () => {
    pushIntoHistory({
      command: typedCommand,
      success: true,
      output: <Timeline />,
    });
  };

  // execute the neo command
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

  // execute the help command
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

  // execute the tech command
  const executeTech = async () => {
    pushIntoHistory({
      command: typedCommand,
      success: true,
      output: <Tech />,
    });
  };

  // attempt to execute the current command
  const executeCommand = async () => {
    // normalize the command so we're comparing all lowercase strings and remove
    // any additional whitespace
    const command = typedCommand.toLowerCase().trim();

    // check if this could possibly be an easter egg command
    if (easterEggResponse.hasOwnProperty(command)) {
      return pushIntoHistory({
        command: command,
        success: false,
        output: easterEggResponse[command],
      });
    }

    // if the typed command is not in the list of available commands
    if (!availableCommands.hasOwnProperty(command)) {
      // reset the currently typed command
      setTypedCommand('');

      // add a failed command into the stack to display
      pushIntoHistory({
        command: command,
        success: false,
        output: `davesh: command not found: ${command}`,
      });
    }

    // execute the proper function based on the command the user entered
    switch (command) {
      case 'help':
        await executeHelp();
        break;
      case 'clear':
        await executeClear();
        break;
      case 'story':
        await executeStory();
        break;
      case 'timeline':
        await executeTimeline();
        break;
      case 'neo':
        await executeTheOne();
        break;
      case 'motd':
        await executeMOTD();
        break;
      case 'menu':
        await executeMenu();
        break;
      case 'tech':
        await executeTech();
        break;
    }

    reset();
  };

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
