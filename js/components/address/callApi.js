import $ from 'jquery';
function getProvinces() {
  return new Promise(function (resolve, reject) {
    const url = 'https://provinces.open-api.vn/api/p';
    $.ajax({
      method: 'get',
      url: url,
      timeout: 1000,
      success: function (response) {
        resolve(response);
      },
      error: function (error) {
        reject(error);
      }
    })
  })
}

function getDistrictByProvince() {
  return new Promise(function (resolve, reject) {
    const url = 'https://provinces.open-api.vn/api/d';
    $.ajax({
      method: 'get',
      url: url,
      timeout: 1000,
      success: function (response) {
        resolve(response);
      },
      error: function (error) {
        reject(error);
      }
    })
  })
}

function getWardByDistrict() {
  return new Promise(function (resolve, reject) {
    const url = 'https://provinces.open-api.vn/api/w/';
    $.ajax({
      method: 'get',
      url: url,
      timeout: 1000,
      success: function (response) {
        resolve(response);
      },
      error: function (error) {
        reject(error);
      }
    })
  })
}
export { getProvinces, getDistrictByProvince, getWardByDistrict };