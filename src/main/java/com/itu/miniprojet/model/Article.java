package com.itu.miniprojet.model;

import java.text.Normalizer;
import java.time.LocalDateTime;

import jakarta.persistence.Column;
import jakarta.persistence.Entity;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import jakarta.persistence.Table;

@Entity
@Table(name = "article")
public class Article {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_article")
    private int id;

    @Column(name = "title", length = 255)
    private String title;
    
    @Column(name = "slug", length = 255)
    private String slug;

    @Column(name = "content", columnDefinition = "TEXT")
    private String content;

    //*-- for meta thingy
    @Column(name = "summary", length = 500)
    private String summary;

    @Column(name = "created_at")
    private LocalDateTime createdAt;
    
    @Column(name = "authors")
    private String authors;

    //?==== Constructors
    public Article() {}

    public Article(String _title, String _content, String _authors) {
        setTitle(_title);
        this.content = _content;
        this.authors = _authors;
    }

    //?==== Getters
    public int getId() { return id; }
    public String getTitle() { return title; }
    public String getSlug() { return slug; }
    public String getContent() { return content; }
    public LocalDateTime getCreatedAt() { return createdAt; }
    public String getAuthors() { return authors; }
    public String getSummary() { return summary; }

    //?==== Setters
    public void setId(int id) { this.id = id; }
    public void setTitle(String title) {
        this.title = title;
        this.slug = generateSlug(title);
    }
    public void setSlug(String slug) { this.slug = slug; }
    public void setContent(String content) { this.content = content; }
    public void setCreatedAt(LocalDateTime createdAt) { this.createdAt = createdAt; }
    public void setAuthors(String authors) { this.authors = authors; }
    public void setSummary(String summary) { this.summary = summary; }

    //?=== Utilities
    private String generateSlug(String input) {
        if (input == null) return "";
        
        // 1. Remove accents (Normalization)
        String normalized = Normalizer.normalize(input, Normalizer.Form.NFD);
        String accentFree = normalized.replaceAll("\\p{InCombiningDiacriticalMarks}+", "");

        // 2. Lowercase, replace non-alphanumeric with hyphens, and trim
        return accentFree.toLowerCase()
            .replaceAll("[^a-z0-9\\s]", "")
            .trim()
            .replaceAll("\\s+", "-");
    }

    public void ensureSummary() {
        if (this.summary == null || this.summary.trim().isEmpty()) {
            // Strip HTML tags using regex
            String plainText = (this.content != null) ? this.content.replaceAll("<[^>]*>", "") : "";
            String combined = this.title + " - " + plainText;
            
            if (combined.length() > 150) {
                this.summary = combined.substring(0, 147) + "...";
            } else {
                this.summary = combined;
            }
        }
    }
    
    @Override
    public String toString() {
        return "Article [id=" + id + ", title=" + title + ", slug=" + slug + 
            ", created=" + createdAt + ", authors=" + authors + "]";
    }

}
