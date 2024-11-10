import $ from 'jquery';

function getUserInfoFromToken() {
  $.ajax({
    method: 'get',
    url: 'get-user-info',
    success: function (response) {
      if (response.status === 201) {
        const userInfo = response.user.data;
        const fullName = userInfo.full_name;
        const lastName = fullName.split(' ').pop();

        let avatar = userInfo.avatar
        $('.user-info').css('display', 'block')
        $('.user-info').find('.user-name').text(lastName);
        if (userInfo.avatar !== null || userInfo.avatar === undefined) {
          $('#user-icon').attr('src').val(avatar);
        }
      } else {
        console.log(response)
      }
    }
  })
}

export default getUserInfoFromToken;