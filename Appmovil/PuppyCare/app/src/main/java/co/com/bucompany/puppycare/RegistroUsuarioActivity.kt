package co.com.bucompany.puppycare

import android.app.Activity
import android.support.v7.app.AppCompatActivity
import android.os.Bundle
import android.util.Log
import android.view.View
import android.widget.Button
import android.widget.EditText
import android.widget.Toast
import com.android.volley.DefaultRetryPolicy
import com.android.volley.Request
import com.android.volley.Response
import com.android.volley.toolbox.StringRequest
import com.android.volley.toolbox.Volley

class RegistroUsuarioActivity : AppCompatActivity() {
    private var usuario: EditText?=  null
    private var email: EditText?= null
    private var contrasena: EditText?= null
    private var recontrasena: EditText?= null
    private var registrar: Button?= null

    //Declaro la variable url del web service a consumir
    //private val url = "http://192.168.1.73/puppycare/api/v1/registroUsuario"
    private val url = "http://192.168.0.15/puppycare/api/v1/registroUsuario"

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_registro_usuario)
        usuario = findViewById<View>(R.id.etUsuarioRe) as EditText
        email = findViewById<View>(R.id.etEmailRe) as EditText
        contrasena = findViewById<View>(R.id.etContrasena) as EditText
        recontrasena = findViewById<View>(R.id.etReContrasena) as EditText
        registrar = findViewById<View>(R.id.btRegistrar) as Button

        //Evento Boton Registrar
        registrar?.setOnClickListener(View.OnClickListener {
            if(usuario?.text.toString().isEmpty() || email?.text.toString().isEmpty() || contrasena?.text.toString().isEmpty() || recontrasena?.text.toString().isEmpty()){
                toast("Rellene campos vacios")
            }else{
                if(contrasena?.text.toString() != recontrasena?.text.toString()){
                    toast("Las contraseñas no coinciden")
                }else{
                    registrarRequest()
                }
            }
        })
    }

    fun registrarRequest(){
        val queue = Volley.newRequestQueue(this)
        val response:String?=null
        val finalResponse = response
        val postRequest = object : StringRequest(Request.Method.POST, url, Response.Listener<String>{
            response ->
            toast(response)
            Log.d("AGREGADO", response)
            if(response == "Usuario ya existe"){
                toast("Usuario ya existe")
            }

            if(response == "Mailer_Error"){
                toast("Se produjo un error enviando el correo")
            }
            if(response == "Enviado"){
                toast("Revise su correo electronico para confirmar la cuenta")
                remove()
            }
            if(response == "Error"){
                toast("Se produjo un error, intente de nuevo")
            }
        }, Response.ErrorListener {
            Log.d("ErrorResponse", finalResponse)
        }){
            override fun getParams(): Map<String, String>{
                val params = HashMap<String, String>()
                params.put("Email_", email?.text.toString())
                params.put("Usuario_", usuario?.text.toString())
                params.put("Contrasena_", contrasena?.text.toString())
                return params
            }
        }
        postRequest.retryPolicy = DefaultRetryPolicy(0, DefaultRetryPolicy.DEFAULT_MAX_RETRIES, DefaultRetryPolicy.DEFAULT_BACKOFF_MULT)
        queue.add(postRequest)

    }

    //Method for Toast
    //Metodo para abreviar la utilizacion de los toast
    fun Activity.toast(setToast: CharSequence) {
        Toast.makeText(this, setToast, Toast.LENGTH_SHORT).show()
    }

    fun remove(){
        usuario?.text?.clear()
        email?.text?.clear()
        contrasena?.text?.clear()
        recontrasena?.text?.clear()

    }
}

