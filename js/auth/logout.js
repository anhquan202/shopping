import $ from 'jquery';

function logout() {
  try {
    $('#logout').on('click', function (e) {
      e.preventDefault();
      if (confirm('Do you want to log out your website?')) {
        $.ajax({
          method: 'get',
          url: 'logout',
          success: function (response) {
            if (response.status === 201) {
              alert(response.message);
              window.location.href = '/shopping';
            } else {
              alert('Logout failed, please try again!');
            }
          },
          error: function (error) {
            console.log(error);
            alert('An error occurred while logging out.');
          }
        });
      }
    });
  } catch (error) {
    console.log(error);
    alert('An error occurred during the logout process.');
  }
}
export default logout;
