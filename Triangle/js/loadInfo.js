if (loginFlag) {
	$(xml).find("Account").each(function () {
		if ($(this).find("Id").text() == accountId) {
			$('#editNameText').attr("value", ($(this).find("Name").text()));
			$('#editHomeText').attr("value", ($(this).find("Home").text()));
			$('#editAddressText').attr("value", ($(this).find("Address").text()));
			$('#editPhone').attr("value", ($(this).find("Phone").text()));
		}
	});
}