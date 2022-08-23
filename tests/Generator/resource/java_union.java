import com.fasterxml.jackson.annotation.JsonProperty;
public class Creature {
    private String kind;
    @JsonProperty("kind")
    public void setKind(String kind) {
        this.kind = kind;
    }
    @JsonProperty("kind")
    public String getKind() {
        return this.kind;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("kind", this.kind);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonProperty;
public class Human extends Creature {
    private String firstName;
    @JsonProperty("firstName")
    public void setFirstName(String firstName) {
        this.firstName = firstName;
    }
    @JsonProperty("firstName")
    public String getFirstName() {
        return this.firstName;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("firstName", this.firstName);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonProperty;
public class Animal extends Creature {
    private String nickname;
    @JsonProperty("nickname")
    public void setNickname(String nickname) {
        this.nickname = nickname;
    }
    @JsonProperty("nickname")
    public String getNickname() {
        return this.nickname;
    }
    public Map<String, Object> toMap() {
        Map<String, Object> map = new HashMap<>();
        map.put("nickname", this.nickname);
        return map;
    }
}

import com.fasterxml.jackson.annotation.JsonProperty;
public class Union {
    private Object union;
    private Object intersection;
    private Object discriminator;
    @JsonProperty("union")
    public void setUnion(Object union) {
        this.union = union;
    }
    @JsonProperty("union")
    public Object getUnion() {
        return this.union;
    }
    @JsonProperty("intersection")
    public void setIntersection(Object intersection) {
        this.intersection = intersection;
    }
    @JsonProperty("intersection")
    public Object getIntersection() {
        return this.intersection;
    }
    @JsonProperty("discriminator")
    public void setDiscriminator(Object discriminator) {
        this.discriminator = discriminator;
    }
    @JsonProperty("discriminator")
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
