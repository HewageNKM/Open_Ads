const showModal = () => {
    const modal = document.getElementById("modal_post");
    modal.classList.add("post_modal_enabled");
    modal.classList.remove("post_modal_disabled");
};


const hideModal = () => {
    modal = document.getElementById("modal_post");
    modal.classList.add("post_modal_disabled");
    modal.classList.remove("post_modal_enabled");
}