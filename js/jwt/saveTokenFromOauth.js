function saveTokenFromGoogle() {
  $.ajax({
    url: 'login/redirect-google',
    success: function (response) {
      if (response.jwt) {
        localStorage.setItem('authToken', response.jwt);
        window.location.href = '/shopping';
      } else {
        console.log('Invalid token');
      }
    },
    error: function (xhr, status, error) {
      console.error(error);
    }
  });
}
export default saveTokenFromGoogle;