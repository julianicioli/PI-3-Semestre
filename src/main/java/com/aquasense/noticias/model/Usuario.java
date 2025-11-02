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
import jakarta.validation.constraints.Email;
import jakarta.validation.constraints.NotBlank;
import jakarta.validation.constraints.Size;

@Entity
@Table(name = "tb_usuarios")
public class Usuario {
	
	@Id
	@GeneratedValue(strategy = GenerationType.IDENTITY)
	private Long id;
	
	@Column(length = 255)
	@Size(min = 3, max = 255, message = "O atributo Nome deve ter no mínimo 3 e no máximo 255 caracteres")
	@NotBlank(message = "O atributo Nome é obrigatório!")
	private String nome;
	
	@Column(length = 255)
	@Size(min = 3, max = 255, message = "O atributo Função deve ter no mínimo 3 e no máximo 255 caracteres")
	@NotBlank(message = "O atributo Função é obrigatório!")
	private String funcao;
	
	//@Schema(example = "email@email.com.br") - caso no futuro configure o Swagger
	@NotBlank(message = "O e-mail é obrigatório.")
	@Email(message = "O e-mail deve ser válido.")
	private String email;
	
	@NotBlank(message = "O atributo Senha é obrigatório.")
	@Size(min=8, message = "A senha deve ter no mínimo 8 caracteres.")
	private String senha;
	
	// Relacionamento:
	
	@OneToMany(fetch = FetchType.LAZY, mappedBy = "autor")
	@JsonIgnoreProperties(value = "autor", allowSetters = true)
	private List<Noticia> noticias = new ArrayList<>();
	
	
	// Getters e Setters:

	public Long getId() {
		return id;
	}

	public void setId(Long id) {
		this.id = id;
	}

	public String getNome() {
		return nome;
	}

	public void setNome(String nome) {
		this.nome = nome;
	}

	public String getFuncao() {
		return funcao;
	}

	public void setFuncao(String funcao) {
		this.funcao = funcao;
	}

	public String getEmail() {
		return email;
	}

	public void setEmail(String email) {
		this.email = email;
	}

	public String getSenha() {
		return senha;
	}

	public void setSenha(String senha) {
		this.senha = senha;
	}

	public List<Noticia> getNoticias() {
		return noticias;
	}

	public void setNoticias(List<Noticia> noticias) {
		this.noticias = noticias;
	}
	

}
