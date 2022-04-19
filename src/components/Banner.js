import Menu from './Menu';
export default function Banner() {
  return (
    <div className="banner">
      <div>
        Welcome to Davenix 32.4.10 LTS (GNU/Linux 5.3.90-management x86_64)
      </div>
      <Menu />
      <div>System information as of {new Date().toString()}</div>
      <div className="row">
        <div className="column">
          <ul className="sys-list">
            <li>
              <pre>{`System load:`.padEnd(13)} 0.0</pre>
            </li>
            <li>
              <pre>{`Usage of /:`.padEnd(13)} 5.3% of 1990 GB</pre>
            </li>
            <li>
              <pre>{`Memory usage:`.padEnd(13)} 32%</pre>
            </li>
            <li>
              <pre>{`Swap usage:`.padEnd(13)} 0%</pre>
            </li>
          </ul>
        </div>
        <div className="column">
          <ul className="sys-list">
            <li>
              <pre>{`Processes:`.padEnd(20)} 87</pre>
            </li>
            <li>
              <pre>{`Users logged in:`.padEnd(20)} 9</pre>
            </li>
            <li>
              <pre>{`IP address for eth0:`.padEnd(20)} 127.0.0.1</pre>
            </li>
          </ul>
        </div>
      </div>
    </div>
  );
}
