import { useState, useEffect } from 'react';

export default function BashLine({ text, currentCommand }) {
  const [printedText, setPrintedText] = useState('');
  const [complete, setComplete] = useState(false);
  const randBetween = (min, max) => {
    // min and max included
    return Math.floor(Math.random() * (max - min + 1) + min);
  };

  useEffect(() => {
    if (text) {
      const letters = text.split('');
      let totalTimeout = 0;
      letters.reduce((word, letter) => {
        const timeoutAmount = randBetween(20, 50);
        console.log(word, letter);
        totalTimeout += timeoutAmount;
        const newText = word + letter;
        setTimeout(() => {
          setPrintedText(newText);
          if (newText === text) {
            setTimeout(() => {
              setComplete(true);
            }, 500);
          }
        }, totalTimeout);

        return newText;
      }, '');
    }
  }, []);

  return (
    <div>
      {complete === false && (
        <div className="command-group">
          <div className="bash-line">
            <span className="blue-text">╭─&nbsp;</span>
            <span className="blue-bg">www</span>
            <span className="orange-bg">~/projects/davidrallen.com</span>
          </div>
          <div className="bash-line">
            <span className="blue-text">╰─</span>
            <span className="orange-text">$&nbsp;</span>
            <span className="command">{printedText}</span>
          </div>
        </div>
      )}
      {complete === true && (
        <>
          <div className="command-group">
            <div className="bash-line">
              <span className="green-text">❯</span> {printedText}
            </div>
          </div>
          <div className="command-group">
            <div className="bash-line">
              <span className="blue-text">╭─&nbsp;</span>
              <span className="blue-bg">www</span>
              <span className="orange-bg">~/projects/davidrallen.com</span>
            </div>
            <div className="bash-line">
              <span className="blue-text">╰─</span>
              <span className="orange-text">$&nbsp;</span>
              <span className="command">
                {currentCommand}
                <span className="blinking-cursor">&#9608;</span>
              </span>
            </div>
          </div>
        </>
      )}
    </div>
  );
}
