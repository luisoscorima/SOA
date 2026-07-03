package pe.edu.utp.arcacontinental.wms.model;

public class ValidacionInventarioResponseActualizarExito {

    private boolean ok;
    private String idValidacion;
    private String estado;
    private String mensaje;

    public boolean isOk() {
        return ok;
    }

    public void setOk(boolean ok) {
        this.ok = ok;
    }

    public String getIdValidacion() {
        return idValidacion;
    }

    public void setIdValidacion(String idValidacion) {
        this.idValidacion = idValidacion;
    }

    public String getEstado() {
        return estado;
    }

    public void setEstado(String estado) {
        this.estado = estado;
    }

    public String getMensaje() {
        return mensaje;
    }

    public void setMensaje(String mensaje) {
        this.mensaje = mensaje;
    }
}
