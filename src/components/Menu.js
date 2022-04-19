export default function Banner() {
  return (
    <ul className="menu">
      <li>
        <pre>
          {`* Resume:`.padEnd(10)}{' '}
          <a href="/">https://davidrallen.com/resume.pdf</a>
        </pre>
      </li>
      <li>
        <pre>
          {`* GitHub:`.padEnd(10)}{' '}
          <a target="_blank" href="https://github.com/doctorallen">
            https://github.com/doctorallen
          </a>
        </pre>
      </li>
      <li>
        <pre>
          {`* Contact:`.padEnd(10)}{' '}
          <a target="_blank" href="mailto:jobs@davidrallen.com?subject=Hello">
            jobs@davidrallen.com
          </a>
        </pre>
      </li>
    </ul>
  );
}
