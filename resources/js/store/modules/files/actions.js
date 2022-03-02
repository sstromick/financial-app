import api from '@/api';

const getFiles = context => {
  api.getUrl(context, '/api/files', 'FILES_UPDATED');  
};


const getFile = context => {
    api.getUrl(context, '/api/file', 'FILE_UPDATED');
}

const createFile = (context, payload) => {
  api.postUrl(context, '/api/files', payload, 'FILE_UPDATED');  
};

const updateFile = (context, payload) => {
    api.patchUrl(context, '/api/files/' + payload.id, payload, 'FILE_UPDATED');
}

export default {
    getFiles,
    getFile,
    createFile,
    updateFile
};