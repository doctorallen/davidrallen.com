import './index.scss';
import BashLine from './components/BashLine';
import { useEffect, useState } from 'react';
import useKeyPress from './useKeyPress';

function App() {
  const [typedCommand, setTypedCommand] = useState('');

  const handleKeyUp = (event) => {
    console.log(event.key);
    console.log(typedCommand);
    setTypedCommand(typedCommand + event.key);
  };

  useKeyPress(handleKeyUp);

  return (
    <div className="App">
      <BashLine
        currentCommand={typedCommand}
        text='Welcome to my website. Type "help" for a list of all available commands.'
      />
    </div>
  );
}

export default App;
