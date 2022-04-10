import { useState, useEffect } from 'react';

export default function BashLine({ command }) {
  const [printedText, setPrintedText] = useState('');
  const [complete, setComplete] = useState(false);

  return (
    <div>
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
            {command}
            <span className="blinking-cursor">&#9608;</span>
          </span>
        </div>
      </div>
    </div>
  );
}
