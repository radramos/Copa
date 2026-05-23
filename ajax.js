export async function openAddPartida() {
  var form = document.getElementById("formulario");
  form.showModal();
  var params = new URLSearchParams({
    func: "add",
  });
  await fetch("ajaxRouter.php?", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: params.toString(),
  })
    .then((response) => response.text())
    .then((html) => {
      form.innerHTML = html;
    });
}
export async function openEditPartida(id) {
  var form = document.getElementById("formulario");
  form.showModal();
  var params = new URLSearchParams({
    func: "edit",
    id: id,
  });
  await fetch("ajaxRouter.php?", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: params.toString(),
  })
    .then((response) => response.text())
    .then((html) => {
      form.innerHTML = html;
    });
}
export function closeFocusForm() {
  const form = document.getElementById("formulario");
  form.innerHTML = "";
  form.close();
}
