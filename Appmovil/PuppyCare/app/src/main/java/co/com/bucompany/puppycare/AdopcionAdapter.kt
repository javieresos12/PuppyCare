package co.com.bucompany.puppycare

import android.content.Context
import android.support.v7.widget.RecyclerView
import android.view.LayoutInflater
import android.view.View
import android.view.ViewGroup
import android.widget.Button
import android.widget.ImageView
import android.widget.TextView
import android.widget.Toast
import com.bumptech.glide.Glide

/**
 * Created by wrodr on 11/01/2018.
 */
class AdopcionAdapter(val mascotaList: ArrayList<Mascota>, val ctx: Context): RecyclerView.Adapter<AdopcionAdapter.ViewHolder>() {

    override fun getItemCount(): Int {
        return mascotaList.size
    }

    override fun onCreateViewHolder(parent: ViewGroup?, viewType: Int): ViewHolder {
        val v = LayoutInflater.from(parent?.context).inflate(R.layout.lista_adopcion, parent, false)
        return ViewHolder(v)
    }

    override fun onBindViewHolder(holder: ViewHolder?, position: Int) {
        val mascota: Mascota = mascotaList[position]

        holder?.textViewNombre?.text = mascota.nombre
        holder?.textViewDescripcion?.text = mascota.descripcion
        holder?.textViewEdad?.text = "Edad: " + mascota.edad
        holder?.textViewRaza?.text = "Raza: " + mascota.raza
        holder?.textViewUbicacion?.text = mascota.ciudad
        Glide.with(ctx).load(mascota.foto).into(holder?.imageViewFoto)
        holder?.btnAdoptar?.setOnClickListener(View.OnClickListener {
            Toast.makeText(ctx, "Adoptaras a: "+mascota.nombre, Toast.LENGTH_SHORT).show()
        })


    }


    class ViewHolder(itemView: View) : RecyclerView.ViewHolder(itemView) {
        val textViewNombre = itemView.findViewById<View>(R.id.nombreMascota) as TextView
        val textViewRaza = itemView.findViewById<View>(R.id.razaMascota) as TextView
        val textViewEdad = itemView.findViewById<View>(R.id.edadMascota) as TextView
        val textViewUbicacion = itemView.findViewById<View>(R.id.ubicacionMascota) as TextView
        val textViewDescripcion = itemView.findViewById<View>(R.id.descripcionMascota) as TextView
        val imageViewFoto = itemView.findViewById<View>(R.id.fotoMascota) as ImageView
        val btnAdoptar = itemView.findViewById<View>(R.id.btnAdoptarMascota) as Button

    }

}