package com.aquasense.noticias.model;

import java.time.LocalDate;

import com.fasterxml.jackson.annotation.JsonIgnoreProperties;

import jakarta.persistence.Column;
import jakarta.persistence.Entity;
import jakarta.persistence.FetchType;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import jakarta.persistence.JoinColumn;
import jakarta.persistence.Lob;
import jakarta.persistence.ManyToOne;
import jakarta.persistence.Table;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.NotNull;
import jakarta.validation.constraints.Size;

@Entity
@Table(name = "tb_noticias")
public class Noticia {
	
	@Id
	@GeneratedValue(strategy = GenerationType.IDENTITY) //auto-increment
	private Long id;
	
	@Column(length=50)
	@NotBlank(message= "O título é obrigatório.")
	private String titulo;
	
	@Lob //campo mapeado como Text no MySQL  
	@NotBlank(message = "O atributo conteúdo é obrigatório!")
	@Size(min = 20, message = "O texto deve conter pelo menos 20 caracteres")
	private String conteudo;
	
	@NotBlank(message = "O atributo foto é obrigatório.")
	private String foto;
	
	@NotNull(message = "O Atributo Data de Publicação é obrigatório.")
	private LocalDate dataPublicacao;
	
	@Column(nullable = true) //campo pode ser null
	private LocalDate dataAtualizacao;
	
	
	//Relacionamento:
	@ManyToOne(fetch = FetchType.LAZY) //cada notícia possui uma categoria
	@JoinColumn(name = "categoria_id") //define chave estrangeira, categoria_id será criado no BD
	@JsonIgnoreProperties("noticias") // opcional para evitar loop
	private Categoria categoria;

	@ManyToOne(fetch = FetchType.LAZY) //cada notícia possui um autor
	@JoinColumn(name = "usuario_id", nullable = true) //nullable permite que o usuário seja opcional
	@JsonIgnoreProperties("noticias") //evita loop infinito, usuário tem uma lista de notícias
	private Usuario autor;

	//Getters e Setters:
	
	public Long getId() {
		return id;
	}

	public void setId(Long id) {
		this.id = id;
	}

	public String getTitulo() {
		return titulo;
	}

	public void setTitulo(String titulo) {
		this.titulo = titulo;
	}

	public String getConteudo() {
		return conteudo;
	}

	public void setConteudo(String conteudo) {
		this.conteudo = conteudo;
	}

	public String getFoto() {
		return foto;
	}

	public void setFoto(String foto) {
		this.foto = foto;
	}

	public LocalDate getDataPublicacao() {
		return dataPublicacao;
	}

	public void setDataPublicacao(LocalDate dataPublicacao) {
		this.dataPublicacao = dataPublicacao;
	}

	public LocalDate getDataAtualizacao() {
		return dataAtualizacao;
	}

	public void setDataAtualizacao(LocalDate dataAtualizacao) {
		this.dataAtualizacao = dataAtualizacao;
	}

	public Categoria getCategoria() {
		return categoria;
	}

	public void setCategoria(Categoria categoria) {
		this.categoria = categoria;
	}

	public Usuario getAutor() {
		return autor;
	}

	public void setAutor(Usuario autor) {
		this.autor = autor;
	}
	
	
}
