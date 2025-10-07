function printUserCodeCard(username, userCode) {
  const popup = window.open('', '', 'height=600,width=400');
  popup.document.write(`
    <html>
    <head>
      <title>${username}'s User Code</title>
      <style>
        body {
          font-family: Arial, sans-serif;
          background-color: #f9f9f9;
          margin: 0;
          padding: 20px;
        }
        .card {
          background: #fff;
          border: 2px solid #198754;
          border-radius: 12px;
          padding: 20px;
          max-width: 350px;
          margin: 0 auto;
          text-align: center;
          box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .icon {
          margin-bottom: 10px;
        }
        .icon svg {
          width: 60px;
          height: 60px;
          fill: #198754;
        }
        .username {
          font-size: 22px;
          font-weight: 700;
          margin-bottom: 10px;
          color: #333;
        }
        .label {
          color: #777;
          margin-bottom: 5px;
          font-size: 14px;
        }
        .code {
          font-size: 24px;
          font-weight: bold;
          color: #198754;
          margin-bottom: 20px;
        }
        .note {
          font-size: 12px;
          color: #666;
          border-top: 1px dashed #ccc;
          padding-top: 10px;
        }
      </style>
    </head>
    <body>
      <div class="card">
        <div class="icon">
          <svg xmlns="http://www.w3.org/2000/svg" fill="#198754" viewBox="0 0 24 24">
            <path d="M12 2a5 5 0 1 1 0 10a5 5 0 0 1 0-10zm0 12c-4.97 0-9 2.16-9 5v1a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-1c0-2.84-4.03-5-9-5z"/>
          </svg>
        </div>
        <div class="username">${username}'s User Code</div>
        <div class="label">Your Unique Code</div>
        <div class="code">${userCode}</div>
        <div class="note">
          Please save this code safely. It is required for password reset and wallet loading.
        </div>
      </div>
    </body>
    </html>
  `);
  popup.document.close();
  popup.focus();
  popup.print();
}
