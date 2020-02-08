// function check() {
//     if (true) {
//         return true;
//     }
//     if (true) {
//         return false;
//     }
// }
// if (check()) {
//     console.log('true')
// } else {
//     console.log('false');
// }
// if (false && true && true) {
//     console.log(1);
// }
let pass = '@wW12345';
let reg = /(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\W_]).{6,16}/;
if (reg.test(pass)) {
    console.log('true');
} else {
    console.log('false');
}