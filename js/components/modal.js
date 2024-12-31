import $ from 'jquery';
export function modal() {
  const modalOverlay = $('#modal-overlay');
  const btnChange = $('.change-address');

  btnChange.on('click', function (e) {
    e.preventDefault();
    modalOverlay.css({
      'display': 'flex',
      'justify-content': 'center'
    });

  });

  modalOverlay.on('click', function (e) {
    if ($(e.target).is('#modal-overlay')) {
      modalOverlay.css('display', 'none');
    }
  });
}
