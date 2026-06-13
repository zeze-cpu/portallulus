<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($title ?? 'PortalLulus') ?></title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    body {
      font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
      min-height: 100vh;
      background: #0f172a;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow-y: auto;
    }

    /* Animated background blobs */
    body::before {
      content: '';
      position: fixed;
      top: -20%;
      left: -10%;
      width: 600px;
      height: 600px;
      background: radial-gradient(circle, rgba(79,70,229,0.35) 0%, transparent 70%);
      border-radius: 50%;
      animation: blobFloat 8s ease-in-out infinite alternate;
    }
    body::after {
      content: '';
      position: fixed;
      bottom: -20%;
      right: -10%;
      width: 500px;
      height: 500px;
      background: radial-gradient(circle, rgba(124,58,237,0.3) 0%, transparent 70%);
      border-radius: 50%;
      animation: blobFloat 10s ease-in-out infinite alternate-reverse;
    }

    @keyframes blobFloat {
      0%   { transform: translate(0, 0) scale(1); }
      100% { transform: translate(30px, 20px) scale(1.05); }
    }

    .auth-container {
      width: 100%;
      max-width: 860px;
      padding: 20px;
      position: relative;
      z-index: 1;
    }

    .auth-card {
      background: rgba(255,255,255,0.97);
      backdrop-filter: blur(20px);
      padding: 44px 40px;
      border-radius: 28px;
      box-shadow: 0 32px 80px rgba(0,0,0,0.4), 0 0 0 1px rgba(255,255,255,0.1);
      margin: 0 auto;
      max-width: 440px;
      animation: cardIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
    }
    .auth-card.wide { max-width: 840px; }

    @keyframes cardIn {
      from { transform: translateY(20px) scale(0.97); opacity: 0; }
      to   { transform: translateY(0) scale(1); opacity: 1; }
    }

    .auth-header {
      text-align: center;
      margin-bottom: 36px;
    }

    .auth-logo {
      width: 80px;
      height: 80px;
      background: linear-gradient(135deg, #4f46e5, #7c3aed);
      border-radius: 22px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 20px;
      font-size: 38px;
      color: white;
      box-shadow: 0 12px 24px rgba(79,70,229,0.35);
    }

    .auth-title {
      font-size: 26px;
      font-weight: 800;
      color: #0f172a;
      letter-spacing: -0.03em;
      margin-bottom: 6px;
    }

    .auth-subtitle {
      font-size: 14px;
      color: #64748b;
      font-weight: 500;
    }

    .form-group { margin-bottom: 18px; }

    .form-label {
      display: block;
      font-size: 12.5px;
      font-weight: 700;
      color: #374151;
      margin-bottom: 8px;
      letter-spacing: 0.01em;
    }

    .input-wrap {
      position: relative;
    }

    .input-icon {
      position: absolute;
      left: 14px;
      top: 50%;
      transform: translateY(-50%);
      color: #9ca3af;
      font-size: 19px;
      pointer-events: none;
    }

    .form-control {
      width: 100%;
      padding: 13px 16px 13px 44px;
      border: 1.5px solid #e5e7eb;
      border-radius: 12px;
      font-size: 14.5px;
      font-family: inherit;
      color: #111827;
      background: #f9fafb;
      transition: all 0.2s;
      appearance: none;
    }

    .form-control:focus {
      outline: none;
      border-color: #4f46e5;
      background: white;
      box-shadow: 0 0 0 4px rgba(79,70,229,0.12);
    }
    .form-control::placeholder { color: #9ca3af; }

    .btn-login {
      width: 100%;
      padding: 14px;
      background: linear-gradient(135deg, #4f46e5, #7c3aed);
      color: white;
      border: none;
      border-radius: 12px;
      font-size: 15px;
      font-weight: 700;
      font-family: inherit;
      cursor: pointer;
      transition: all 0.25s;
      box-shadow: 0 8px 20px rgba(79,70,229,0.35);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      margin-top: 8px;
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 14px 28px rgba(79,70,229,0.4);
    }
    .btn-login:active { transform: translateY(0); }

    .auth-error {
      background: #fef2f2;
      color: #dc2626;
      padding: 13px 16px;
      border-radius: 10px;
      font-size: 13.5px;
      margin-bottom: 20px;
      border: 1px solid #fecaca;
      font-weight: 600;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .auth-error::before {
      content: '\eb97';
      font-family: 'boxicons';
      font-size: 18px;
    }

    .auth-footer-link {
      text-align: center;
      margin-top: 28px;
      padding-top: 22px;
      border-top: 1px solid #f1f5f9;
    }

    .auth-footer-link a {
      font-size: 13.5px;
      color: #4f46e5;
      text-decoration: none;
      font-weight: 700;
      display: inline-flex;
      align-items: center;
      gap: 7px;
      transition: opacity 0.2s;
    }
    .auth-footer-link a:hover { opacity: 0.8; }
  </style>
</head>
<body>
  <div class="auth-container">
    <?php require $view_file; ?>
  </div>
</body>
</html>
