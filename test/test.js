function check() {
    let pass = false
    if (false) {
        return true;
    } else if (false) {
        passFlag = false;
    } else {
        if (true) {
            if (true) {
                return pass;
            }

        }
    }
    return passFlag;
}
if (check()) {
    console.log('true');
}
if (!check()) {
    console.log('false');
}