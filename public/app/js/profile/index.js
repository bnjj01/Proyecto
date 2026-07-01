document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('form-change-password');
  if (!form) return;

  const showMessage = (msg, success = true) => {
    let container = document.getElementById('profile-message');
    if (!container) {
      container = document.createElement('div');
      container.id = 'profile-message';
      form.parentNode.insertBefore(container, form);
    }
    container.innerHTML = `<div class="alert ${success ? 'alert-success' : 'alert-danger'}" role="alert">${msg}</div>`;
    setTimeout(() => container.innerHTML = '', 5000);
  };

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(form));
    try {
      const res = await fetch(window.APP_URL + 'profile/changePassword', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
      });
      const json = await res.json();
      showMessage(json.message || 'Respuesta inesperada', json.success === true);
      if (json.success) form.reset();
    } catch (err) {
      showMessage('Error de red. Intenta nuevamente.', false);
      console.error(err);
    }
  });
});