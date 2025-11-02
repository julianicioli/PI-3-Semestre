package com.aquasense.noticias.model;

import java.util.ArrayList;
import java.util.List;

import com.fasterxml.jackson.annotation.JsonIgnoreProperties;

import jakarta.persistence.Column;
import jakarta.persistence.Entity;
import jakarta.persistence.FetchType;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import jakarta.persistence.OneToMany;
import jakarta.persistence.Table;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.Size;

@Entity
@Table(name="tb_categoria")
public class Categoria {
	
	@Id
	@GeneratedValue(strategy = GenerationType.IDENTITY)
	private Long id;
	
	@Column(length=50) 
    @NotBlank(message = "A categoria da notícia é obrigatória.")
    @Size(min=5, max=50, message="O atributo categoria deve conter no mínimo 05 e no máximo 50 caracteres")
	private String categoria; //categoria: rascunho, publicado, arquivado
	
    // Relacionamento
    @OneToMany(fetch = FetchType.LAZY, mappedBy = "categoria")
    @JsonIgnoreProperties(value = "categoria", allowSetters = true)
    private List<Noticia> noticias = new ArrayList<>();
    
    
    //Getters e Setters

	public Long getId() {
		return id;
	}

	public void setId(Long id) {
		this.id = id;
	}

	public String getCategoria() {
		return categoria;
	}

	public void setCategoria(String categoria) {
		this.categoria = categoria;
	}

	public List<Noticia> getNoticias() {
		return noticias;
	}

	public void setNoticias(List<Noticia> noticias) {
		this.noticias = noticias;
	}
    
    

}




	



