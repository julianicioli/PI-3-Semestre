package com.aquasense.noticias.repository;

import java.util.List;

import org.springframework.data.jpa.repository.JpaRepository;

import com.aquasense.noticias.model.Usuario;

public interface UsuarioRepository extends JpaRepository<Usuario, Long> {
	public List<Usuario> findAllByNomeContainingIgnoreCase(String nome); //Query Methods
}
