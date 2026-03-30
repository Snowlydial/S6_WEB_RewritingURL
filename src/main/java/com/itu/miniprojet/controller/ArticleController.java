package com.itu.miniprojet.controller;

import java.io.IOException;
import java.nio.file.Files;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.Map;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.ModelAttribute;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.multipart.MultipartFile;
import net.coobird.thumbnailator.Thumbnails;

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
        model.addAttribute("pageTitle", "New Article");
        return "bo/article-form";
    }

    @GetMapping("/edit/{id}")
    public String showEditForm(@PathVariable int id, Model model) {
        Article article = articleService.findById(id);
        model.addAttribute("article", article);
        model.addAttribute("pageTitle", "Edit Article");
        return "bo/article-form";
    }

    @PostMapping("/save")
    public String saveArticle(@ModelAttribute Article article) {
        articleService.saveArticle(article);
        return "redirect:/article/list";
    }

    @GetMapping("/delete/{id}")
    public String deleteArticle(@PathVariable int id) {
        articleService.deleteArticle(id);
        return "redirect:/article/list"; 
    }

    //?=== For image upload
    @PostMapping("/upload-image")
    @ResponseBody
    public Map<String, String> uploadImage(@RequestParam("file") MultipartFile file) {
        try {
            String originalName = file.getOriginalFilename();
            
            // Normalize extension to jpg for compression consistency
            String fileName = System.currentTimeMillis() + "_" + 
                originalName.replaceAll("\\.[^.]+$", ".jpg");
            Path path = Paths.get("uploads/" + fileName);
            Files.createDirectories(path.getParent());

            Thumbnails.of(file.getInputStream())
                .size(800, 800)
                .outputFormat("jpg")
                .outputQuality(0.80)
                .toFile(path.toFile());

            return Map.of("location", "/uploads/" + fileName);
        } catch (IOException e) {
            return Map.of("error", "Failed to upload image");
    }
}
    
}
