package co.com.bucompany.puppycare

import android.app.Activity
import android.app.AlertDialog
import android.content.Context
import android.content.Intent
import android.os.Bundle
import android.support.design.widget.NavigationView
import android.support.v4.view.GravityCompat
import android.support.v4.widget.DrawerLayout
import android.support.v7.app.ActionBarDrawerToggle
import android.support.v7.app.AppCompatActivity
import android.support.v7.widget.LinearLayoutManager
import android.support.v7.widget.RecyclerView
import android.support.v7.widget.Toolbar
import android.util.Log
import android.view.MenuItem
import android.view.View
import android.widget.*
import com.android.volley.DefaultRetryPolicy
import com.android.volley.Request
import com.android.volley.Response
import com.android.volley.toolbox.JsonObjectRequest
import com.android.volley.toolbox.StringRequest
import com.android.volley.toolbox.Volley
import com.bumptech.glide.Glide
import org.json.JSONObject

class DashboardActivity : AppCompatActivity(), NavigationView.OnNavigationItemSelectedListener {

    //Declaro los widgets
    private var imagenPerfil: de.hdodenhof.circleimageview.CircleImageView?= null
    private var tvShowUserNavHeader: TextView?= null
    private var navigationView: NavigationView? = null
    private var drawer: DrawerLayout? = null
    private var navHeader: View? = null
    private var tvShowEmailUserNavHeader: TextView?= null
    private var toolbar: Toolbar?= null
    var name: String ?= null
    private var recycler: RecyclerView?= null
    val mascotas = ArrayList<Mascota>()

    //Declaro las URL de los webservices
    //private val url = "http://192.168.1.73/puppycare/api/v1/obtenerInfo"
    private val url = "http://192.168.0.15/puppycare/api/v1/obtenerInfo"
    //private val url = "http://172.20.10.3/puppycare/api/v1/obtenerInfo"
    //private val urlInfo = "http://192.168.1.73/puppycare/api/v1/registroInfo"
    private val urlInfo = "http://192.168.0.15/puppycare/api/v1/registroInfo"
    private val getMascota = "http://192.168.0.15/puppycare/api/v1/getMascotasJson"
    //private val getMascota = "http://172.20.10.3/puppycare/api/v1/getMascotasJson"


    override fun onCreate(savedInstanceState: Bundle?) {
        super.onCreate(savedInstanceState)
        setContentView(R.layout.activity_dashboard)
        //Obtener el dato enviado desde la ventana de Login
        val bundle = intent.extras
        name = bundle.get("usuario_").toString();

        drawer = findViewById<View>(R.id.drawer_layout) as DrawerLayout
        navigationView = findViewById<View>(R.id.nav_view) as NavigationView
        toolbar = findViewById<View>(R.id.toolbar) as Toolbar
        recycler = findViewById<View>(R.id.lista) as RecyclerView

        recycler?.layoutManager = LinearLayoutManager(this, LinearLayout.VERTICAL, false)


        //mascotas.add(nombre, raza, ciudad, edad, descripcion, foto)
        //mascotas.add(Mascota("1","Princesa", "Chanda", "Barranquilla", "1 mes", "Perro chanda disponible para adopcion", "https://instagram.fctg1-1.fna.fbcdn.net/t51.2885-15/e35/18514084_284958161966795_8985987223014866944_n.jpg"))
        //mascotas.add(Mascota("2","Cleta", "Pinscher", "Barranquilla", "1 mes", "Perro chanda disponible para adopcion", "https://instagram.fctg1-1.fna.fbcdn.net/t51.2885-15/e35/18514084_284958161966795_8985987223014866944_n.jpg"))
        //recycler?.adapter = AdopcionAdapter(mascotas, this)

        setSupportActionBar(toolbar)
        supportActionBar?.setDisplayHomeAsUpEnabled(true)
        supportActionBar?.setHomeAsUpIndicator(R.mipmap.ic_menu)
        supportActionBar?.setHomeButtonEnabled(true)

        val toggle = ActionBarDrawerToggle(this, drawer, toolbar, R.string.drawer_open, R.string.drawer_close)
        drawer?.addDrawerListener(toggle)
        toggle.syncState()

        // Navigation view header
        navHeader = navigationView!!.getHeaderView(0)

        tvShowUserNavHeader = navHeader!!.findViewById<View>(R.id.tvusernamer) as TextView
        tvShowEmailUserNavHeader = navHeader!!.findViewById<View>(R.id.tvemailde) as TextView
        imagenPerfil = navHeader!!.findViewById<View>(R.id.circle_image) as de.hdodenhof.circleimageview.CircleImageView

        //funcion para dar evento a los menu del navigation, es alimentada por el metodo onNavigationItemSelected
        //Declarado abajo
        navigationView?.setNavigationItemSelectedListener(this)

        //Obtener datos para alimentar los widget con datos del usuario
        getData()
        getMascotasAll()

    }

    //Metodos usados

    //Para manipular el navigatiopnView
    override fun onBackPressed() {
        if (drawer!!.isDrawerOpen(GravityCompat.START)) {
            drawer!!.closeDrawer(GravityCompat.START)
        } else {
            super.onBackPressed()
        }
    }

    //Para obtener todos los datos del usuario logueado
    private fun getData(){
        //Creo un jsonobject
        val jsonobj = JSONObject()
        //Agrego informacion al jsonobject
        jsonobj.put("usuario_",name.toString())
        //Instancio la libreria volley
        val queue = Volley.newRequestQueue(this)
        //parametros de la peticion (Tipo_de_peticion, url, parametros(puede ir null, en caso de ser GET), Response)
        val re = JsonObjectRequest(Request.Method.POST, url, jsonobj,Response.Listener {
            response ->
            //Muestro uno de los datos traidos, a manera de prueba
            tvShowUserNavHeader?.text = response["Nombre_Usuario"].toString()
            tvShowEmailUserNavHeader?.text = response["Email"].toString()
            // Loading profile image
            Glide.with(this).load(response["Foto_Perfil"]).into(imagenPerfil)
            //Confirmo uno de los estados solicitados, para terminar de completar informacion de usuario
            if(response["Estado_Inf"].toString() == "Incompleto"){
                //invoco un metodo que me crea un dialogo personalizado donde capturo datos para completar informacion
                showAlert(response["Ind"].toString())
            }
            //invoco el metodo que me permite guardar los datos del usuario
            saveSharedPreferences(response["Ind"].toString(),response["Cedula"].toString(),response["Nombre_Usuario"].toString(),
                    response["Email"].toString(),response["Nombres"].toString(),response["Apellidos"].toString(),response["Ciudad"].toString(),
                    response["Telefono"].toString(),response["Celular"].toString())

        },Response.ErrorListener {
            toast("Algo salio mal cargando datos del usuario")

        })
        queue.add(re)
    }

    //Para cerrar Sesion y vaciar el sharedPreferences
    private fun logoutRequest() {
        //Al cerrar sesion vacio el SharedPreferences y redirigo a la ventana de login
        val sharedPreferences = getSharedPreferences("userInfo", Context.MODE_PRIVATE)
        val editor = sharedPreferences.edit()
        editor.putString("Ind_", "")
        editor.putString("cedula_", "")
        editor.putString("usuario_", "")
        editor.putString("email_", "")
        editor.putString("nombres_", "")
        editor.putString("apellidos_", "")
        editor.putString("ciudad_", "")
        editor.putString("telefono_", "")
        editor.putString("celular_", "")
        editor.putString("Estado_Conexion", "")
        editor.apply()
        val intent = Intent(this, LoginActivity::class.java)
        startActivity(intent)
        finish()
    }

    //Metodo que me permite guardar los datos del usuario
    fun saveSharedPreferences(ind: String, cedula: String, usuario: String, email: String, nombres: String, apellidos: String, ciudad: String,
                              telefono: String, celular: String){
        val sharedPreferences = getSharedPreferences("userInfo", Context.MODE_PRIVATE)
        val editor = sharedPreferences.edit()
        editor.putString("Ind_", ind)
        editor.putString("cedula_", cedula)
        editor.putString("usuario_", usuario)
        editor.putString("email_", email)
        editor.putString("nombres_", nombres)
        editor.putString("apellidos_", apellidos)
        editor.putString("ciudad_", ciudad)
        editor.putString("telefono_", telefono)
        editor.putString("celular_", celular)
        editor.putString("Estado_Conexion", "Conectado")
        editor.apply()

    }

    //Metodo para mostrar mensajes en un toast
    fun Activity.toast(setToast: CharSequence) {
        Toast.makeText(this, setToast, Toast.LENGTH_SHORT).show()
    }

    //Muestra un alertDialogo personalizado cuando el usuario no ha completado toda la info
    fun showAlert(Ind: String){
        val alertDilog = AlertDialog.Builder(this)
        val dialogoView = layoutInflater.inflate(R.layout.dialogo_registro_info, null)
        val NombresUser = dialogoView.findViewById<EditText>(R.id.NombresUser)
        val ApellidosUser = dialogoView.findViewById<EditText>(R.id.ApellidosUser)
        val CedulaUser = dialogoView.findViewById<EditText>(R.id.CedulaUser)
        val TelefonoUser = dialogoView.findViewById<EditText>(R.id.TelefonoUser)
        val CelularUser = dialogoView.findViewById<EditText>(R.id.CelularUser)
        val CiudadUser = dialogoView.findViewById<EditText>(R.id.CiudadUser)
        val btEnviarInfo = dialogoView.findViewById<Button>(R.id.btEnviarInfo)
        btEnviarInfo.setOnClickListener(View.OnClickListener {
            if(NombresUser?.text.toString().isEmpty() || ApellidosUser?.text.toString().isEmpty()
                    || CedulaUser?.text.toString().isEmpty() || TelefonoUser?.text.toString().isEmpty()
                    || TelefonoUser?.text.toString().isEmpty() || CedulaUser?.text.toString().isEmpty()
                    || CiudadUser?.text.toString().isEmpty()){
                toast("Rellene campos vacios")
            }else {

                //Instancio la libreria volley
                val queue = Volley.newRequestQueue(this)
                //declaro variables que contendran el response
                val response: String? = null
                val finalResponse = response
                //Inicio la peticion
                val postRequest = object : StringRequest(Request.Method.POST, urlInfo, Response.Listener<String> { response ->
                    if (response == "YaExiste") {
                        toast("Cedula ya registrada")
                    }
                    if (response == "Actualizado") {
                        toast("Información actualizada")

                    }
                    if (response == "Error") {
                        toast("Ocurrio un error")
                    }
                }, Response.ErrorListener {
                    Log.d("ErrorResponse", finalResponse)
                }) {
                    //Funcion para enviar data al web service
                    override fun getParams(): Map<String, String> {
                        val params = HashMap<String, String>()
                        params.put("Nombres_", NombresUser?.text.toString())
                        params.put("Apellidos_", ApellidosUser?.text.toString())
                        params.put("cedula_", CedulaUser?.text.toString())
                        params.put("telefono_", TelefonoUser?.text.toString())
                        params.put("celular_", CelularUser?.text.toString())
                        params.put("ciudad_", CiudadUser?.text.toString())
                        params.put("Ind_", Ind)
                        return params;
                    }
                }
                //Agrego la peticion a la cola
                postRequest.retryPolicy = DefaultRetryPolicy(0, DefaultRetryPolicy.DEFAULT_MAX_RETRIES, DefaultRetryPolicy.DEFAULT_BACKOFF_MULT)
                queue.add(postRequest)
                NombresUser?.text?.clear()
                ApellidosUser?.text?.clear()
                CedulaUser?.text?.clear()
                TelefonoUser?.text?.clear()
                CelularUser?.text?.clear()
                CiudadUser?.text?.clear()

            }
        })
        alertDilog.setView(dialogoView)
        alertDilog.setCancelable(true)
        alertDilog.show()
    }

    //Metodo que alimenta la funcion setNavigationItemSelectedListener declarada en la parte de arriba
    //Aqui se le dan eventos a cada menu del navigation
    override fun onNavigationItemSelected(item: MenuItem): Boolean {
        when(item.itemId){
            R.id.logout -> {
                logoutRequest()
            }
        }
        drawer?.closeDrawer(GravityCompat.START)
        return true
    }

    fun getMascotasAll(){

        //Instancio la libreria volley
        val queue = Volley.newRequestQueue(this)
        //parametros de la peticion (Tipo_de_peticion, url, parametros(puede ir null, en caso de ser GET), Response)
        val re = StringRequest(Request.Method.GET, getMascota, Response.Listener {
            response ->
            val objJson = JSONObject(response)
            val arrJson = objJson.getJSONArray("data")
            for(i in 0..arrJson!!.length() -1){
                val res = arrJson.getJSONObject(i)
                mascotas.add(Mascota(res.getString("Ind"),res.getString("Nombre"), res.getString("Raza"),res.getString("Ciudad"),res.getString("Edad"),res.getString("Descripcion"),res.getString("Foto")
                ))
                recycler?.adapter = AdopcionAdapter(mascotas, this)

            }
            //toast(response.toString())

        }, Response.ErrorListener {
            toast("NO ok")
        })

        queue.add(re)

    }




}


