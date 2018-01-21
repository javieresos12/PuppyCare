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

class RecuperarContrasenaActivity : AppCompatActivity() {

    //Declaro los widgets a utilizar
    private var emailRe: EditText?= null
    private var botonRecuperar: Button?= null

    //Declaro la variable url del web service a consumir
    //private val url = "http://192.168.1.73/puppycare/api/v1/recuperarPass"
    private val url = "http://192.168.0.15/puppycare/api/v1/recuperarPass"

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_recuperar_contrasena)
        //Especifico los widgets con sus respectivos id
        emailRe = findViewById<View>(R.id.etEmailRecuperar) as EditText
        botonRecuperar = findViewById<View>(R.id.btRecuperar) as Button
        botonRecuperar?.setOnClickListener(View.OnClickListener {
            if(emailRe?.text.toString().isEmpty()){
                toast("Rellene el campo del email")
            }else{
                recuperarContrasena()

            }

        })

    }

    private fun recuperarContrasena(){
        //Instancio la libreria volley
        val queue = Volley.newRequestQueue(this)
        //declaro variables que contendran el response
        val response: String?= null
        val finalResponse = response
        //Inicio la peticion
        var postRequest = object : StringRequest(Request.Method.POST, url, Response.Listener<String>{
            response ->
            toast(response)
            if(response == "Error"){
                toast("Ocurrio un error")
            }
            if(response == "Enviado"){
                toast("Revise su correo electronico")
                emailRe?.text?.clear()
            }
            if(response == "No activo"){
                toast("El usuario aun no ha sido activado")
            }
            if(response == "No existe"){
                toast("El Email no existe")
            }
        }, Response.ErrorListener {
            Log.d("ErrorResponse", finalResponse)
        }){
            override fun getParams(): Map<String, String>{
                val params = HashMap<String, String>()
                params.put("email_re_", emailRe?.text.toString())
                return params;
            }
        }
        //Agrego la peticion a la cola
        postRequest.retryPolicy = DefaultRetryPolicy(0, DefaultRetryPolicy.DEFAULT_MAX_RETRIES, DefaultRetryPolicy.DEFAULT_BACKOFF_MULT)
        queue.add(postRequest)
    }

    fun Activity.toast(setToast: CharSequence) {
        Toast.makeText(this, setToast, Toast.LENGTH_SHORT).show()
    }
}

