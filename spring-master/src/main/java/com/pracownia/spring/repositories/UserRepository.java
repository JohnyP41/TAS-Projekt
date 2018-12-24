package com.pracownia.spring.repositories;
import com.pracownia.spring.entities.User;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.CrudRepository;
import org.springframework.data.repository.PagingAndSortingRepository;

public interface UserRepository extends CrudRepository<User, Integer>, PagingAndSortingRepository<User, Integer> {

    User findByUserId(String UserId);

    @Query("select count(*) from User p where p.id = ?1")
    Integer checkIfExist(Integer id);
}
