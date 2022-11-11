// tratar os erros das requisições via axios
export function showError(e) {
    if (e.response.status === 403) {
        swal.fire("Falha!", "Ação Não Autorizada", "error");
    } else if (e && e.response && e.response.data) {
        swal.fire("Falha!", "Algo Inesperado Aconteceu tente novamente", error);
    } else if (typeof e === 'string') {
        swal.fire("Falha!", "Algo Inesperado Aconteceu, tente novamente", error);
    } else {
        swal.fire("Falha!", "Algo Inesperado Aconteceu, tente novamente", error);
    }
}

export default {
    showError
}
