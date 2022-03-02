const FILES_UPDATED = (state, files) => {
  state.files = files;  
};


const FILE_UPDATED = (state, file) => {
    state.file = file;  
};



export default {
    FILES_UPDATED,
    FILE_UPDATED,
};