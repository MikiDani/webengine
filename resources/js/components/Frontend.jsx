import React from 'react';
import ReactDOM from 'react-dom/client';

function Frontend(props) {
  return (
    <div className="container">
      <div className="row justify-content-center">
        <div className="col-md-8">
          <div className="card">
            <div className="card-header bg-primary text-white">SIKERÜLT Jee :P</div>
            <div className="card-body">
              <p>{props.sessionMessage}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}

export default Frontend;

if (document.getElementById('frontend')) {
  const frontendElement = document.getElementById("frontend")
  const sessionMessage = frontendElement.getAttribute('session-message')

  console.log(sessionMessage)

  const Index = ReactDOM.createRoot(frontendElement)

  Index.render(
    <React.StrictMode>
      <Frontend sessionMessage={sessionMessage} />
    </React.StrictMode>
  )
}
