package com.aquasense.noticias.repository;

import java.util.List;

import org.springframework.data.jpa.repository.JpaRepository;

import com.aquasense.noticias.model.Noticia;

public interface NoticiaRepository extends JpaRepository<Noticia, Long> {
	public List<Noticia> findAllByTituloContainingIgnoreCase(String titulo); //Query Methods

}
