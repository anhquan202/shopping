import $ from 'jquery';
import { getProvinces, getDistrictByProvince, getWardByDistrict } from './callApi';

let selectedProvince = '';
let selectedDistrict = '';
let selectedWard = '';

function getAddressData() {
  displayProvinces();
  displayDistrictByProvince();
  displayWardByDistrict();
}

function updateAddress() {
  const fullAddress = [selectedProvince, selectedDistrict, selectedWard]
    .filter(Boolean)
    .join(', ');
  $('#address').val(fullAddress);
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

  $('#province').on('click', function () {
    renderAddressList(provinces, 'province', 'province')
  })
}

//Show District by Specific Province 
function displayDistrictByProvince() {
  $('.list-address').on('click', 'li[data-province-code]', async function () {
    const provinceCode = $(this).data('province-code');

    if (!provinceCode) {
      return;
    };
    selectedDistrict = '';
    selectedWard = '';
    selectedProvince = $(this).text();
    updateAddress();

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
  })
}

//Show Ward by Specific District from Province 
function displayWardByDistrict() {
  $('.list-address').on('click', 'li[data-district-code]', async function () {
    const districtCode = $(this).data('district-code');

    if (!districtCode) {
      return;
    };

    selectedDistrict = $(this).text();
    updateAddress();

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
  })

  $('.list-address').on('click', 'li[data-ward-code]', function () {
    selectedWard = $(this).text();
    updateAddress();
  });
}

export default getAddressData;