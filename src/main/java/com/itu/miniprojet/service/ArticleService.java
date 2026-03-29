package com.itu.miniprojet.service;

import java.time.LocalDateTime;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.itu.miniprojet.model.Article;
import com.itu.miniprojet.repository.ArticleRepository;

@Service
public class ArticleService {
    @Autowired
    private ArticleRepository articleRepository;

    public Article saveArticle(Article article) {
        if (article.getCreatedAt() == null) article.setCreatedAt(LocalDateTime.now());
        return articleRepository.save(article);
    }


}
