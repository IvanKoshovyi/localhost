function editBooking(id) {
    var width = 470;
    var height = 250;
    var left = (screen.width / 2) - (width / 2);
    var top = (screen.height / 2) - (height / 2);
    var url = 'edit-booking.php?id=' + id;
    window.open(url, '_blank', 'width=' + width + ', height=' + height + ', left=' + left + ', top=' + top);
}