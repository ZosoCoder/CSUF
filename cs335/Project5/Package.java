public class Package {
	private String name;
	private int size;
	private int votes;

	public Package() {
		name = "";
		size = 0;
		votes = 0;
	}

	public Package(String name, int size, int votes) {
		this.name = name;
		this.size = size;
		this.votes = votes;
	}

	public void setName(String name) {
		this.name = name;
	}

	public void setSize(int size) {
		this.size = size;
	}

	public void setVotes(int votes) {
		this.votes = votes;
	}

	public String getName() {
		return name;
	}

	public int getSize() {
		return size;
	}

	public int getVotes() {
		return votes;
	}
}