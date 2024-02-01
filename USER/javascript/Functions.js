// function to validate SA ID field
function isValidSouthAfricanID(id) {
    // Check if ID is 13 digits
    if (!/^\d{13}$/.test(id)) return false;

    // Extract parts of the ID
    const birthDate = id.substring(0, 6);
    const genderCode = parseInt(id.substring(6, 10), 10);
    const citizenship = parseInt(id.charAt(10), 10);
    const checkDigit = parseInt(id.charAt(12), 10);

    // Check birth date validity
    const yearPrefix = (parseInt(birthDate.substring(0, 2), 10) >= 0 && parseInt(birthDate.substring(0, 2), 10) <= 22) ? 2000 : 1900;
    const year = yearPrefix + parseInt(birthDate.substring(0, 2), 10);
    const month = parseInt(birthDate.substring(2, 4), 10) - 1; // Month is 0-indexed in JavaScript Date
    const day = parseInt(birthDate.substring(4, 6), 10);
    const birthDateObj = new Date(year, month, day);
    if (birthDateObj.getFullYear() !== year || birthDateObj.getMonth() !== month || birthDateObj.getDate() !== day) {
        return false;
    }

    // Check gender code
    if (genderCode < 0 || genderCode > 9999) return false;

    // Check citizenship
    if (citizenship !== 0 && citizenship !== 1) return false;

    // Luhn algorithm for checksum
    function luhnCheck(id) {
        let sumOdd = 0;
        let sumEven = 0;
        let evenConcat = '';

        for (let i = 0; i < id.length - 1; i++) {
            if (i % 2 === 0) {
                sumOdd += parseInt(id[i], 10);
            } else {
                evenConcat += (parseInt(id[i], 10) * 2).toString();
            }
        }

        for (let i = 0; i < evenConcat.length; i++) {
            sumEven += parseInt(evenConcat[i], 10);
        }

        let totalSum = sumOdd + sumEven;
        return (10 - (totalSum % 10)) % 10;
    }

    let calculatedCheckDigit = luhnCheck(id);
    return calculatedCheckDigit === checkDigit;
}
