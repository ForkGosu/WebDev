
const signUpBtn = document.getElementById("signUp");
const signInBtn = document.getElementById("signIn");
const container = document.querySelector(".container");

signUpBtn.addEventListener("click", () => {
  container.classList.add("right-panel-active");
});
signInBtn.addEventListener("click", () => {
  container.classList.remove("right-panel-active");
});

// document.querySelector(".close").addEventListener("click", function() {
//     // 창을 닫는 코드 작성
//     // 예를 들어, 모달 창을 닫는다면:
//     // document.getElementById("myModal").style.display = "none";
//     document.querySelector('.error-message').style.display = 'none';
// });
