export default function Banner() {
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
}
