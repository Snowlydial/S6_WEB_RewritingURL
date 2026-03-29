package com.itu.miniprojet.model;

import jakarta.persistence.Column;
import jakarta.persistence.Entity;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import jakarta.persistence.Table;

@Entity
@Table(name = "role")
public class Role {
    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_role")
    private int id;

    @Column(name = "label", length = 50)
    private String label;

    //?==== Constructors
    public Role() {}

    public Role(String label) {
        this.label = label;
    }

    //?==== Getters
    public int getId() { return id; }
    public String getLabel() { return label; }

    //?==== Setters
    public void setId(int id) { this.id = id; }
    public void setLabel(String label) { this.label = label; }

    @Override
    public String toString() {
        return "Role [id=" + id + ", label=" + label + "]";
    }
    
}
