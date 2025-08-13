// Password toggle with icon swap
document.addEventListener('DOMContentLoaded', () => {
  const passwordInput = document.getElementById('password');
  const toggleBtn = document.getElementById('togglePassword');

  if (!passwordInput || !toggleBtn) return;

  toggleBtn.addEventListener('click', () => {
    const shouldShow = passwordInput.type === 'password';

    passwordInput.type = shouldShow ? 'text' : 'password';
    toggleBtn.classList.toggle('is-visible', shouldShow);

    // Accessibility
    toggleBtn.setAttribute('aria-pressed', String(shouldShow));
    toggleBtn.setAttribute(
      'aria-label',
      shouldShow ? 'Hide password' : 'Show password'
    );
  });
});
