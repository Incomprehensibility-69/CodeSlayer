// Show/hide password toggle
document.addEventListener('DOMContentLoaded', function() {
	const passwordInput = document.getElementById('password');
	const toggleBtn = document.getElementById('togglePassword');
	if (passwordInput && toggleBtn) {
		toggleBtn.addEventListener('click', function() {
			if (passwordInput.type === 'password') {
				passwordInput.type = 'text';
				toggleBtn.textContent = 'Hide';
			} else {
				passwordInput.type = 'password';
				toggleBtn.textContent = 'Show';
			}
		});
	}
});
