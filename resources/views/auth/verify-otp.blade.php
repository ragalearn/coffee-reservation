<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Code - Reservasi Maiway</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* BASE STYLE */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body, html { width: 100%; min-height: 100%; font-family: 'Inter', sans-serif; background-color: #F5F5F5; display: flex; align-items: center; justify-content: center; }

        /* CARD STYLE */
        .verify-wrapper { width: 100%; display: flex; justify-content: center; align-items: center; padding: 20px; }
        .verify-card { 
            background: #ffffff; 
            width: 100%; 
            max-width: 586px; 
            border-radius: 20px; 
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1); 
            padding: 60px 60px; 
            display: flex; 
            flex-direction: column; 
            text-align: center;
        }

        /* TEXT STYLE */
        .verify-header { margin-bottom: 35px; }
        .verify-title { font-size: 36px; font-weight: 600; color: #000; margin-bottom: 12px; }
        .verify-subtitle { font-size: 16px; color: #AEACAC; line-height: 1.5; font-weight: 500; }
        .user-email { color: #B5C37C; font-weight: 600; }

        /* OTP INPUTS */
        .otp-container { 
            display: flex; 
            justify-content: center; 
            gap: 15px; 
            margin-bottom: 30px; 
        }
        .otp-input { 
            width: 70px; 
            height: 70px; 
            background-color: #F9F9F9; 
            border: 1px solid #EAEAEA; 
            border-radius: 12px; 
            font-size: 28px; 
            font-weight: 600; 
            text-align: center; 
            color: #000; 
            outline: none; 
            transition: all 0.3s ease;
        }
        .otp-input:focus { 
            border-color: #B5C37C; 
            background-color: #fff; 
            box-shadow: 0 0 0 4px rgba(181, 195, 124, 0.1); 
        }

        /* ALERT ERROR */
        .alert-error {
            background-color: #FFE5E5;
            color: #D8000C;
            padding: 12px;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        /* RESEND */
        .resend-text { font-size: 16px; color: #AEACAC; margin-bottom: 40px; }
        .resend-link { color: #B5C37C; text-decoration: none; font-weight: 600; border: none; background: none; cursor: pointer; font-family: inherit; font-size: 16px; }
        .resend-link:hover { text-decoration: underline; }

        /* BUTTON */
        .btn-verify { 
            width: 100%; 
            height: 60px; 
            background-color: #B5C37C; 
            color: #fff; 
            border: none; 
            border-radius: 10px; 
            font-size: 18px; 
            font-weight: 600; 
            cursor: pointer; 
            transition: 0.3s; 
        }
        .btn-verify:hover { background-color: #a4b26a; }

        /* RESPONSIVE */
        @media (max-width: 600px) {
            body, html { background-color: #fff; }
            .verify-card { box-shadow: none; padding: 40px 20px; }
            .otp-input { width: 60px; height: 60px; font-size: 24px; gap: 10px; }
            .verify-title { font-size: 28px; }
        }
    </style>
</head>
<body>

    <div class="verify-wrapper">
        <div class="verify-card">
            <div class="verify-header">
                <h1 class="verify-title">Verify Code</h1>
                <p class="verify-subtitle">
                    Please enter the code we just sent <br> 
                    to email <span class="user-email">{{ $email ?? session('email') ?? 'name@example.com' }}</span>
                </p>
            </div>

            @if ($errors->any())
                <div class="alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('otp.verify') }}">
                @csrf
                <div class="otp-container">
                    <input type="hidden" name="otp_code" id="otp_code">
                    
                    <input type="text" class="otp-input" maxlength="1" pattern="\d*" inputmode="numeric" autofocus required>
                    <input type="text" class="otp-input" maxlength="1" pattern="\d*" inputmode="numeric" required>
                    <input type="text" class="otp-input" maxlength="1" pattern="\d*" inputmode="numeric" required>
                    <input type="text" class="otp-input" maxlength="1" pattern="\d*" inputmode="numeric" required>
                </div>

                <button type="submit" class="btn-verify">Verify</button>
            </form>

            <div style="margin-top: 30px;">
                <p class="resend-text">
                    Didn’t receive OTP? 
                    <form method="POST" action="{{ route('otp.resend') }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="resend-link">Resend Code</button>
                    </form>
                </p>
            </div>
        </div>
    </div>

    <script>
        const inputs = document.querySelectorAll('.otp-input');
        const hiddenInput = document.getElementById('otp_code');

        inputs.forEach((input, index) => {
            // Pindah kursor otomatis
            input.addEventListener('input', (e) => {
                if (e.target.value.length === 1 && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
                updateHiddenInput();
            });

            // Hapus otomatis balik ke belakang
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && e.target.value.length === 0 && index > 0) {
                    inputs[index - 1].focus();
                }
            });
        });

        function updateHiddenInput() {
            let code = "";
            inputs.forEach(input => code += input.value);
            hiddenInput.value = code;
        }

        // Support paste kode OTP
        inputs[0].addEventListener('paste', (e) => {
            const data = e.clipboardData.getData('text').split('');
            inputs.forEach((input, i) => {
                if (data[i]) input.value = data[i];
            });
            updateHiddenInput();
            e.preventDefault();
        });
    </script>
</body>
</html>