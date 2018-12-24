package com.pracownia.spring.entities;

import com.fasterxml.jackson.annotation.JsonIdentityInfo;
import com.fasterxml.jackson.annotation.ObjectIdGenerators;

import javax.persistence.*;
import java.util.BitSet;
import java.util.Set;

/**
 * User entity.
 */
@Entity
@Table(name = "`USER`")
@JsonIdentityInfo(generator=ObjectIdGenerators.IntSequenceGenerator.class,
        property="refId", scope=User.class)
public class User {

    @Id
    @GeneratedValue(strategy = GenerationType.AUTO)
    private Integer id;

    @Column
    private String userId;

    @Column
    private String login;

    @Column
    private String password;

    @Column
    private String name;

    @Column
    private String surname;

    @Column
    private Integer can_Candidate;

    @Column
    private String role;


//    @ManyToMany(fetch = FetchType.LAZY, cascade={CascadeType.PERSIST,  CascadeType.REMOVE})
//    @JoinTable(name = "product_selles")
//    private Set<Seller> sellers = new HashSet<>();

    //required by Hibernate
    public User(){

    }

    public User(String userId, String login, String password, String name, String surname, Integer can_Candidate, String role) {
        this.userId = userId;
        this.login = login;
        this.password = password;
        this.name = name;
        this.surname = surname;
        this.can_Candidate = can_Candidate;
        this.role = role;
    }

    public Integer getId() {
        return id;
    }

    public void setId(Integer id) {
        this.id = id;
    }

    public String getUserId() {
        return userId;
    }

    public void setUserId(String userId) {
        this.userId = userId;
    }

    public String getLogin() {
        return login;
    }

    public void setLogin(String login) {
        this.login = login;
    }

    public String getPassword() {
        return password;
    }

    public void setPassword(String password) {
        this.password = password;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getSurname() {
        return surname;
    }

    public void setSurname(String surname) {
        this.surname = surname;
    }

    public Integer getCan_Candidate() {
        return can_Candidate;
    }

    public void setCan_Candidate(Integer can_Candidate) {
        this.can_Candidate = can_Candidate;
    }

    public String getRole() {
        return role;
    }

    public void setRole(String role) {
        this.role = role;
    }
}
