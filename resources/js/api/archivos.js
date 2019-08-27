const url_base = "/api/v1/archivos";
export default {
    url(){
      return url_base;
    },
    async subirArchivoBase(archivo){
        return await axios.post(url_base + "importar-excel-base", archivo);
    }
}
