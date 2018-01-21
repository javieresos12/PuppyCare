package co.com.bucompany.puppycare

import android.app.Activity
import android.content.Context
import android.content.Intent
import android.support.v7.app.AppCompatActivity
import android.os.Bundle
import android.util.Log
import android.view.View
import android.widget.Button
import android.widget.EditText
import android.widget.TextView
import android.widget.Toast
import com.android.volley.DefaultRetryPolicy
import com.android.volley.Request
import com.android.volley.Response
import com.android.volley.toolbox.StringRequest
import com.android.volley.toolbox.Volley

class LoginActivity : AppCompatActivity() {
    //Declaro los widgets a utilizar
    private var usuario: EditText? = null
    private var password: EditText? = null
    private var login: Button? = null
    private var recuperar: TextView? = null
    private var registrar: TextView? = null

    //Declaro la variable url del web service a consumir
    //private val url = "http://192.168.1.73/puppycare/api/v1/login"
    private val url = "http://192.168.0.15/puppycare/api/v1/login"

    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_login)
        //Invoco el metodo que me permite validar si el usuario esta registrado
        obtenerSharedPreferences()
        //Especifico los widgets con sus respectivos id
        usuario = findViewById<View>(R.id.etUserLogin) as EditText
        password = findViewById<View>(R.id.etPasswordLogin) as EditText
        login = findViewById<View>(R.id.btLogIn) as Button
        recuperar = findViewById<View>(R.id.tvRecuperarPassword) as TextView
        registrar = findViewById<View>(R.id.tvRegistrarUser) as TextView

        //Agrego evento al boton Login
        login?.setOnClickListener(View.OnClickListener {
            //Valido que las caja de texto no esten vacias
            if(usuario?.text.toString().isEmpty() || password?.text.toString().isEmpty()){
                toast("Rellene Campos Vacios")
            }else{
                //Invoco el metodo con la logica del login programada
                loginRequest();
            }
        })
        //Evento para ir a la activity que permite recuperar la contraseña invocando un metodo ya programado
        recuperar?.setOnClickListener(View.OnClickListener {
            ventanaRecuperar()
        })
        //Evento para ir a la activity que permite registrar la cuenta invocando un metodo ya programado
        registrar?.setOnClickListener(View.OnClickListener {
            ventanaRegistrar()
        })
    }

    //Defino el metodo que me permitira hacer el login
    private fun loginRequest(){
        //Instancio la libreria volley
        val queue = Volley.newRequestQueue(this)
        //declaro variables que contendran el response
        val response: String?= null
        val finalResponse = response
        //Inicio la peticion
        val postRequest = object : StringRequest(Request.Method.POST, url, Response.Listener<String> {
            response ->
            //Imprimo el response traido del web service
            //toast(response)
            //Comparo los mensajes traidos del response
            if(response == "noexiste"){
                toast("Usuario no registrado")
            }
            if(response == "Errada"){
                toast("Contraseña incorrecta")
            }
            if(response == "NoActivado"){
                toast("Cuenta no activada, verifique su correo")
            }
            if(response == "Eliminado"){
                toast("Cuenta eliminada, pongase en contacto con soporte")
            }
            if(response == "Correcta"){
                ventanaDashboard()
            }
        },Response.ErrorListener {
            Log.d("ErrorResponse", finalResponse)
        }){
            //Funcion para enviar data al web service
            override fun getParams(): Map<String, String>{
                val params = HashMap<String, String>()
                params.put("usuario_", usuario?.text.toString())
                params.put("contrasena_", password?.text.toString())
                return params;
            }
        }
        //Agrego la peticion a la cola
        postRequest.retryPolicy = DefaultRetryPolicy(0, DefaultRetryPolicy.DEFAULT_MAX_RETRIES, DefaultRetryPolicy.DEFAULT_BACKOFF_MULT)
        queue.add(postRequest)
    }

    //Method for Toast
    //Metodo para abreviar la utilizacion de los toast
    fun Activity.toast(setToast: CharSequence) {
        Toast.makeText(this, setToast, Toast.LENGTH_SHORT).show()
    }

    fun ventanaRegistrar(){
        val intent = Intent(this, RegistroUsuarioActivity::class.java)
        startActivity(intent)
    }

    fun ventanaRecuperar(){
        val intent = Intent(this, RecuperarContrasenaActivity::class.java)
        startActivity(intent)
    }

    fun ventanaDashboard(){
        val intent = Intent(this, DashboardActivity::class.java)
        intent.putExtra("usuario_", usuario?.text.toString())
        startActivity(intent)
        finish()
    }

    fun obtenerSharedPreferences(){
        val sharedPreferences = getSharedPreferences("userInfo", Context.MODE_PRIVATE)
        val estado = sharedPreferences.getString("Estado_Conexion", " ")
        val usuario = sharedPreferences.getString("usuario_", " ")
        if(estado == "Conectado"){
            val intent = Intent(this, DashboardActivity::class.java)
            intent.putExtra("usuario_", usuario?.toString())
            startActivity(intent)
            finish()
        }

    }
}
