import { useState, useEffect } from 'react';

export default function CompletedCommand({ command, output, success = true }) {
  return (
    <div className="command-group">
      <div className="bash-line">
        <span className={success ? 'green-text' : 'red-text'}>❯</span> {command}
      </div>
      {output !== undefined && <div className="bash-line">{output}</div>}
    </div>
  );
}
