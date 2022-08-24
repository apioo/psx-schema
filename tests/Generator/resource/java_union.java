import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
public class Creature {
    private String kind;
    @JsonSetter("kind")
    public void setKind(String kind) {
        this.kind = kind;
    }
    @JsonGetter("kind")
    public String getKind() {
        return this.kind;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("kind", this.kind);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
public class Human extends Creature {
    private String firstName;
    @JsonSetter("firstName")
    public void setFirstName(String firstName) {
        this.firstName = firstName;
    }
    @JsonGetter("firstName")
    public String getFirstName() {
        return this.firstName;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("firstName", this.firstName);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
public class Animal extends Creature {
    private String nickname;
    @JsonSetter("nickname")
    public void setNickname(String nickname) {
        this.nickname = nickname;
    }
    @JsonGetter("nickname")
    public String getNickname() {
        return this.nickname;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("nickname", this.nickname);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonGetter;
import com.fasterxml.jackson.annotation.JsonSetter;
public class Union {
    private Object union;
    private Object intersection;
    private Object discriminator;
    @JsonSetter("union")
    public void setUnion(Object union) {
        this.union = union;
    }
    @JsonGetter("union")
    public Object getUnion() {
        return this.union;
    }
    @JsonSetter("intersection")
    public void setIntersection(Object intersection) {
        this.intersection = intersection;
    }
    @JsonGetter("intersection")
    public Object getIntersection() {
        return this.intersection;
    }
    @JsonSetter("discriminator")
    public void setDiscriminator(Object discriminator) {
        this.discriminator = discriminator;
    }
    @JsonGetter("discriminator")
    public Object getDiscriminator() {
        return this.discriminator;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("union", this.union);
        map.put("intersection", this.intersection);
        map.put("discriminator", this.discriminator);
        return map;
    }
}
