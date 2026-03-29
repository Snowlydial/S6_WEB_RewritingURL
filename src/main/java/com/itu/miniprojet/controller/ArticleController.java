package com.itu.miniprojet.controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;

import com.itu.miniprojet.model.Article;
import com.itu.miniprojet.service.ArticleService;

@Controller
@RequestMapping("/article")
public class ArticleController {

    @Autowired
    private ArticleService articleService;

    @GetMapping("/add")
    public String showArticleForm(Model model) {
        model.addAttribute("article", new Article()); 
        return "bo/article-form";
    }

    @PostMapping("/save")
    public String saveArticle(@ModelAttribute Article article) {
        articleService.saveArticle(article);
        return "redirect:/article/list";
    }
    
}
