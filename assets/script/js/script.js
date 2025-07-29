document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const email = form.querySelector('input[type="email"]');
        const password = form.querySelector('input[type="password"]');
        const mobile = form.querySelector('input[name="mobile"]');
        const code = form.querySelector('input[name="code"]');

        if (email && !email.value.includes('@')) {
            e.preventDefault();
            alert('لطفاً یک ایمیل معتبر وارد کنید.');
        }

        if (password && password.value.length < 6) {
            e.preventDefault();
            alert('رمز عبور باید حداقل ۶ کاراکتر باشد.');
        }

        if (mobile && !/^\d{10,15}$/.test(mobile.value)) {
            e.preventDefault();
            alert('شماره موبایل باید بین ۱۰ تا ۱۵ رقم باشد.');
        }

        if (code && !/^\d{6}$/.test(code.value)) {
            e.preventDefault();
            alert('کد تأیید باید ۶ رقم باشد.');
        }
    });
});

// تغییر بین فرم‌های ورود و ثبت‌نام
const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});