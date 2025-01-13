import $ from 'jquery';

function getUserInfoFromApi() {
  return new Promise(function (resolve, reject) {
    $.ajax({
      method: 'get',
      url: 'get-user-info',
      success: function (response) {
        if (response.status === 201) {
          resolve(response.user);
        } else {
          reject({
            stauts: response.status,
            message: response.message,
          })
        }
      },
      error: function (xhr) {
        reject(xhr.responseJSON);
      }
    })
  })
}

let cachedUserInfo = null;
async function getUserInfoDetail() {
  if (cachedUserInfo) {
    return cachedUserInfo;
  }
  try {
    const userInfo = await getUserInfoFromApi();
    cachedUserInfo = {
      fullName: userInfo.full_name || '',
      userPhone: userInfo.user_phone || '',
      info: userInfo.info || {},
      avatar: userInfo.avatar || null,
    };
    return cachedUserInfo;
  } catch (error) {
    console.error('Error fetching user info:', error);
    throw error;
  }
}
export { getUserInfoFromApi, getUserInfoDetail };