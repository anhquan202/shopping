import $ from 'jquery';
import { getProvinces, getDistrictByProvince, getWardByDistrict } from './callApi';

let selectedProvince = undefined;
let selectedDistrict = undefined;
let selectedWard = undefined;

function getAddressData() {
  displayProvinces();
  displayDistrictByProvince();
  displayWardByDistrict();
}

/**
 * Render danh sách địa chỉ (province, district, ward)
 * @param {Array} list - Danh sách địa chỉ
 * @param {string} unit - Tên đơn vị (province, district, ward)
 * @param {string} key - Khóa dữ liệu tương ứng (province, district, ward)
 */
function renderAddressList(list = {}, unit = '', key = '') {
  $('.list-address').empty();
  if (list) {
    for (let info of list) {
      $('.list-address').append(
        `<li data-${key}-code="${info.code}">${info.name}</li>`
      );
    }
  }
  $('.btn-select').removeClass('active');
  $(`#${unit}`).addClass('active');
}

//Show Provinces
async function displayProvinces() {
  const provinces = await getProvinces();
  renderAddressList(provinces, 'province', 'province')

  $('#province').off('click').on('click', function () {
    renderAddressList(provinces, 'province', 'province')
  })
}

//Show District by Specific Province 
function displayDistrictByProvince() {
  $('.list-address').on('click', 'li[data-province-code]', async function () {
    selectedDistrict = undefined;
    selectedWard = undefined;

    const provinceCode = $(this).data('province-code');

    if (!provinceCode) {
      return;
    };
    selectedProvince = $(this).text();
    try {
      const district = await getDistrictByProvince();
      const districtByProvince = district.reduce(function (result, item) {
        if (item.province_code === provinceCode) {
          result.push(item);
        };
        return result;
      }, []);

      renderAddressList(districtByProvince, 'district', 'district');
    } catch (error) {
      throw new Error(error);
    }
    updateAddress();
  })
}

//Show Ward by Specific District from Province 
function displayWardByDistrict() {
  $('.list-address').on('click', 'li[data-district-code]', async function () {
    selectedWard = undefined;

    const districtCode = $(this).data('district-code');
    if (!districtCode) {
      return;
    };
    selectedDistrict = $(this).text();
    try {
      const wards = await getWardByDistrict();
      const wardByDistrict = wards.reduce(function (result, item) {
        if (item.district_code === districtCode) {
          result.push(item);
        };
        return result;
      }, []);

      renderAddressList(wardByDistrict, 'ward', 'ward');
    } catch (error) {
      throw new Error(error);
    }
    updateAddress();
  })

  $('.list-address').on('click', 'li[data-ward-code]', function () {
    selectedWard = $(this).text();
    updateAddress();
    $('#suggestions-list').slideUp();
  });
}

function updateAddress() {
  const address = [selectedProvince, selectedDistrict, selectedWard];
  const fullAddress = address.filter(Boolean).join(' - ');
  $('.form-group #address').val(fullAddress);
  showSuggestions();
}

function showSuggestions() {
  const addressElement = $('.form-group #address');
  let currentAddress = addressElement.val();

  addressElement.off('focus').on('focus', function () {
    addressElement.siblings('label').addClass('visible');
    addressElement.attr('placeholder', currentAddress);
    addressElement.val('');
    $('#suggestions-list').slideDown();
    $('.btn-select').removeClass('active');
    $('#province').addClass('active');
    displayProvinces();
  });

  addressElement.off('blur').on('blur', function () {
    addressElement.removeAttr('placeholder');
    setTimeout(() => {
      addressElement.val(currentAddress);
      if (selectedProvince !== undefined && selectedDistrict !== undefined && selectedWard !== undefined) {
        addressElement.val(currentAddress);
        $('#suggestions-list').slideUp();
      } else {
        $('#suggestions-list').slideDown();
      }
    }, 50);
  })
}
export default getAddressData;